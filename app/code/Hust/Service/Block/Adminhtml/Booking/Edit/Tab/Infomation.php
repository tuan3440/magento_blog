<?php

namespace Hust\Service\Block\Adminhtml\Booking\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Hust\Service\Model\ServiceRegistry;
use Hust\Service\Model\Source\Hour;
use Hust\Service\Ui\Component\Form\Employee\ListService;

class Infomation extends Generic
{
    protected $serviceRegistry;
    protected $hour;
    protected $service;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry             $registry,
        \Magento\Framework\Data\FormFactory     $formFactory,
        ServiceRegistry $serviceRegistry,
        Hour $hour,
        ListService $service,
        array                                   $data = [])
    {
        $this->service = $service;
        $this->hour = $hour;
        $this->serviceRegistry = $serviceRegistry;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/save', ['booking_id' => $this->getRequest()->getParam('id')]),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ]
            ]
        );
        $form = $this->_formFactory->create();

        $bookingCurrent = $this->serviceRegistry->registry('booking_current');
        $fieldGeneralInformation = $form->addFieldset(
            'infomation_form',
            [
                'legend' => __('General Information')
            ]
        );

        $fieldGeneralInformation->addField(
            'booking_id',
            'hidden',
            [
                'label' => __('Booking ID'),
                'name' => 'booking_id',
                'required' => true,
                'value' => $bookingCurrent->getBookingId()
            ]
        );

        $fieldGeneralInformation->addField(
            'name',
            'text',
            [
                'label' => __('Name'),
                'name' => 'name',
                'required' => true,
                'value' => $bookingCurrent->getName()
            ]
        );

        $fieldGeneralInformation->addField(
            'age',
            'text',
            [
                'label' => __('Age'),
                'name' => 'age',
                'required' => true,
                'value' => $bookingCurrent->getAge()
            ]
        );

        $fieldGeneralInformation->addField(
            'gender',
            'select',
            [
                'label' => __('Gender'),
                'name' => 'gender',
                'required' => true,
                'value' => $bookingCurrent->getGender(),
                'values' => [
                    0 => __('Male'),
                    1 => __('Female')
                ]
            ]
        );

        $fieldGeneralInformation->addField(
            'phone',
            'text',
            [
                'label' => __('Phone'),
                'name' => 'phone',
                'required' => true,
                'value' => $bookingCurrent->getPhone()
            ]
        );

        $fieldGeneralInformation->addField(
            'address',
            'text',
            [
                'label' => __('Address'),
                'name' => 'address',
                'required' => true,
                'value' => $bookingCurrent->getAddress()
            ]
        );

        $fieldGeneralInformation->addField(
            'email',
            'text',
            [
                'label' => __('Email'),
                'name' => 'email',
                'required' => true,
                'value' => $bookingCurrent->getEmail()
            ]
        );

        $fieldGeneralInformation->addField(
            'date',
            'text',
            [
                'label' => __('Date'),
                'name' => 'date',
                'required' => true,
                'value' => $bookingCurrent->getDate()
            ]
        );

        $fieldGeneralInformation->addField(
            'booking_hour',
            'select',
            [
                'label' => __('Hour'),
                'name' => 'booking_hour',
                'required' => true,
                'value' => $bookingCurrent->getBookingHour(),
                'values' => $this->hour->toArray()
            ]
        );

        $fieldGeneralInformation->addField(
            'service_id',
            'select',
            [
                'label' => __('Service'),
                'name' => 'service_id',
                'required' => true,
                'value' => $bookingCurrent->getServiceId(),
                'values' => $this->service->toOptionArray()
            ]
        );

        $fieldGeneralInformation->addField(
            'charge',
            'text',
            [
                'label' => __('Charge'),
                'name' => 'charge',
                'required' => true,
                'value' => $bookingCurrent->getCharge()
            ]
        );

        $fieldGeneralInformation->addField(
            'require',
            'textarea',
            [
                'label' => __('Require of customer'),
                'name' => 'require',
                'value' => $bookingCurrent->getRequire()
            ]
        );

//        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
