<?php
/**
 * @author ArrowHiTech Team
 * @copyright Copyright (c) 2021 ArrowHiTech (https://www.arrowhitech.com)
 */
namespace Dco\Service\Model\System;

use Magento\Backend\Model\Session;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;

class FileUploader
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * FileUploader constructor.
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param Session $session
     * @param Registry $registry
     * @throws FileSystemException
     */
    public function __construct(
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        Session $session,
        Registry $registry
    ) {
        $this->session = $session;
        $this->registry = $registry;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(
            DirectoryList::MEDIA
        );
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @param $fileKey
     * @return array|string[]
     */
    public function uploadFile($fileKey)
    {
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => $fileKey]);

            $uploader->setFilesDispersion(true);
            $result = $uploader->save(
                $this->mediaDirectory->getAbsolutePath(UrlResolver::DIRECTORY_MEDIA)
            );
            unset($result['path']);

            if (!$result) {
                throw new LocalizedException(
                    __('File can not be saved to the destination folder.')
                );
            }

            $result['url'] = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB) . 'pub/media/'
                . $this->getFilePath(UrlResolver::DIRECTORY_MEDIA, $result['file']);
            $result['name'] = $result['file'];

            /** @codingStandardsIgnoreStart */
            $result['filename'] = pathinfo($result['name'], PATHINFO_FILENAME);

            $this->setResultCookie($result);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $result;
    }

    /**
     * @param array|string[] $result
     */
    private function setResultCookie(&$result)
    {
        $result['cookie'] = [
            'name' => $this->session->getName(),
            'value' => $this->session->getSessionId(),
            'lifetime' => $this->session->getCookieLifetime(),
            'path' => $this->session->getCookiePath(),
            'domain' => $this->session->getCookieDomain(),
        ];
    }

    /**
     * @param $path
     * @param $fileName
     *
     * @return string
     */
    public function getFilePath($path, $fileName)
    {
        return rtrim($path, '/') . '/' . ltrim($fileName, '/');
    }
}
