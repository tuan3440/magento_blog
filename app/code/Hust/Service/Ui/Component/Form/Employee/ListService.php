<?php

namespace Hust\Service\Ui\Component\Form\Employee;

use Magento\Framework\Data\OptionSourceInterface;
use Hust\Service\Model\Repository\ServiceRepository;

class ListService implements OptionSourceInterface
{
    private $serviceRepository;

    public function __construct(
        ServiceRepository $serviceRepository
    )
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function toOptionArray()
    {
        $services = $this->serviceRepository->getListService();
        $data = [];
        if ($services) {
            foreach ($services as $service) {
                    $data[] = ['value' => $service->getServiceId(), 'label' => $service->getName()];
            }
        }
        return $data;
    }
}
