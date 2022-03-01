<?php

namespace Hust\Service\Model\System;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;

class UrlResolver
{
    public const DIRECTORY_MEDIA = 'hust/service';

    public const DIRECTORY_TMP_MEDIA = 'hust/service/tmp';

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        UrlInterface $urlBuilder
    ) {
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->urlBuilder = $urlBuilder;
    }

    public function getImageUrlByName($name)
    {
        if (!($service = $this->getFilePath($name, self::DIRECTORY_MEDIA))) {
            return false;
        }

        $baseUrl = $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]);
        $baseUrl = trim(str_replace('index.php', '', $baseUrl), '/');

        return $baseUrl . '/' . $service;
    }

    /**
     * @param string $filename
     * @param string $directoryCode
     *
     * @return bool|string
     */
    private function getFilePath($filename, $directoryCode)
    {
        $file = $directoryCode . DIRECTORY_SEPARATOR . $filename;
        if (!$this->mediaDirectory->isExist($file)) {

            return false;
        }

        return $file;
    }
}

