<?php
/**
 * @author ArrowHiTech Team
 * @copyright Copyright (c) 2021 ArrowHiTech (https://www.arrowhitech.com)
 */
namespace Dco\Service\Model\DataProvider\Service;

use Dco\Service\Api\Data\ServiceInterface;
use Dco\Service\Model\ResourceModel\Service\CollectionFactory;
use Dco\Service\Model\ServiceRepository;
use Dco\Service\Model\System\UrlResolver;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Ui\DataProvider\AbstractDataProvider;

class Form extends AbstractDataProvider
{
    const USE_DEFAULT_FIELDS = [
        ServiceInterface::IMAGE,
        ServiceInterface::CONTENT,
        ServiceInterface::NAME,
        ServiceInterface::IS_ACTIVE
    ];

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var UrlResolver
     */
    private $serviceUrlResolver;

    /**
     * @var ServiceRepository
     */
    private $repository;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var Filesystem\Directory\WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var ServiceInterface|mixed
     */
    private $service;

    public function __construct(
        CollectionFactory $iconCollectionFactory,
        DataPersistorInterface $dataPersistor,
        ServiceRepository $repository,
        RequestInterface $request,
        UrlResolver $serviceUrlResolver,
        Filesystem $filesystem,
        UrlInterface $url,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $iconCollectionFactory->create();
        $this->serviceUrlResolver = $serviceUrlResolver;
        $this->repository = $repository;
        $this->request = $request;
        $this->dataPersistor = $dataPersistor;
        $this->url = $url;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
    }

    /**
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData()
    {
        $data = parent::getData();
        if ($data['totalRecords'] > 0) {
            $service = $this->repository->getById($data['items'][0][ServiceInterface::SERVICE_ID]);
            $serviceData = $service->getData();
            if ($service->getImage()) {
                $serviceData['imagefile'] = [
                    [
                        'name' => $service->getImage(),
                        'url' => $this->serviceUrlResolver->getImageUrlByName($service->getImage()),
                        'previewUrl'  => $this->serviceUrlResolver->getImageUrlByName($service->getImage()),
                        'previewType' => 'image'
                    ]
                ];
            }

            $data[$service->getServiceId()] = $serviceData;
        }

        return $data;
    }

    public function getMeta()
    {
        $meta = parent::getMeta();
        $this->data['config']['submit_url'] = $this->url->getUrl('*/*/save', ['_current' => true]);

        $serviceId = (int)$this->request->getParam(ServiceInterface::SERVICE_ID);
        $store = (int)$this->request->getParam('store');
        if ($serviceId) {
            try {
                $this->service = $this->repository->getById($serviceId);
            } catch (NoSuchEntityException $e) {
                null;
            }
        }

        if ($this->service && $store) {
            $config = [
                'scopeLabel' => __('[STORE VIEW]')
            ];

            $config['service'] = [
                'template' => 'ui/form/element/helper/service',
            ];

            foreach (self::USE_DEFAULT_FIELDS as $field) {
                $config['disabled'] = (bool)$this->service->getData('set_use_default_' . $field);
                $meta['general']['children'][$field]['arguments']['data']['config'] = $config;
            }
        }

        return $meta;
    }
}
