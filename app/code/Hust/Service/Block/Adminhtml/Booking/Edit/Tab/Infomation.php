<?php

namespace Hust\Service\Block\Adminhtml\Booking\Edit\Tab;

use Hust\Service\Helper\Data;
use Hust\Service\Model\Source\BookingStatus;
use Magento\Backend\Block\Widget\Form\Element\Dependence;
use Magento\Backend\Block\Widget\Form\Generic;
use Hust\Service\Model\ServiceRegistry;
use Hust\Service\Model\Source\Hour;
use Hust\Service\Ui\Component\Form\Employee\ListService;
use Magento\Config\Model\Config\Structure\Element\Dependency\Field;

class Infomation extends Generic
{
    protected $serviceRegistry;
    protected $hour;
    protected $service;
    protected $helper;
    protected $bookingStatus;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry             $registry,
        \Magento\Framework\Data\FormFactory     $formFactory,
        ServiceRegistry $serviceRegistry,
        Hour $hour,
        Data $helper,
        BookingStatus $bookingStatus,
        ListService $service,
        array                                   $data = [])
    {
        $this->service = $service;
        $this->hour = $hour;
        $this->serviceRegistry = $serviceRegistry;
        $this->helper = $helper;
        $this->bookingStatus = $bookingStatus;
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
        $htmlIdPrefix = 'booking_setting_';
        $form->setHtmlIdPrefix($htmlIdPrefix);
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
                'value' => $bookingCurrent->getBookingId(),
                'class' => "info_booking"
            ]
        );

        $fieldGeneralInformation->addField(
            'name',
            'text',
            [
                'label' => __('Name'),
                'name' => 'name',
                'required' => true,
                'value' => $bookingCurrent->getName(),
                'disabled' => true,
                'class' => "info_booking"
            ]
        );

        $fieldGeneralInformation->addField(
            'age',
            'text',
            [
                'label' => __('Age'),
                'name' => 'age',
                'required' => true,
                'value' => $bookingCurrent->getAge(),
                'disabled' => true,
                'class' => "info_booking"
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
                ],
                'disabled' => true,
                'class' => "info_booking"
            ]
        );

        $fieldGeneralInformation->addField(
            'phone',
            'text',
            [
                'label' => __('Phone'),
                'name' => 'phone',
                'required' => true,
                'value' => $bookingCurrent->getPhone(),
                'disabled' => true,
                'class' => "info_booking"
            ]

        );

        $fieldGeneralInformation->addField(
            'address',
            'text',
            [
                'label' => __('Address'),
                'name' => 'address',
                'required' => true,
                'value' => $bookingCurrent->getAddress(),
                'disabled' => true,
                'class' => "info_booking"
            ]
        );

        $fieldGeneralInformation->addField(
            'email',
            'text',
            [
                'label' => __('Email'),
                'name' => 'email',
                'required' => true,
                'value' => $bookingCurrent->getEmail(),
                'disabled' => true,
                'class' => "info_booking"
            ]
        );

        $fieldGeneralInformation->addField(
            'date',
            'text',
            [
                'label' => __('Date'),
                'name' => 'date',
                'required' => true,
                'value' => $bookingCurrent->getDate(),
                'disabled' => true,
                'class' => "info_booking"
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
                'values' => $this->hour->toArray(),
                'disabled' => true,
                'class' => "info_booking"
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
                'values' => $this->service->toOptionArray(),
                'disabled' => true,
                'class' => "info_booking"
            ]
        );

        $fieldGeneralInformation->addField(
            'charge',
            'text',
            [
                'label' => __('Charge'),
                'name' => 'charge',
                'required' => true,
                'value' => $bookingCurrent->getCharge(),
                'disabled' => true,
                'class' => "info_booking"
            ]
        );

        $fieldGeneralInformation->addField(
            'require',
            'textarea',
            [
                'label' => __('Require of customer'),
                'name' => 'require',
                'value' => $bookingCurrent->getRequire(),
                'disabled' => true,
                'class' => "info_booking"
            ]
        );

        $fieldGeneralInformation->addField(
            'checkbox',
            'checkbox',
            [
                'label' => __("Update"),
                'name' => 'checkbox',
                'value' => false,
                'class' => "update_booking"
            ]
        );

        $fieldSetting = $form->addFieldset(
            'setting_form',
            [
                'legend' => __('Setting')
            ]
        );

        $fieldSetting->addField(
            'booking_status',
            'select',
            [
                'label' => __('Status'),
                'name' => 'booking_status',
                'required' => true,
                'value' => $bookingCurrent->getBookingStatus() ,
                'values' => $this->bookingStatus->toArray(),

            ]
        );

        $fieldSetting->addField(
            'employee_id',
            'select',
            [
                'label' => __('Employee'),
                'name' => 'employee_id',
                'value' => $this->helper->getEmployeeOfBooking($bookingCurrent->getBookingId()) ?? '' ,
                'values' => $this->helper->getListEmployeeAvailable(
                    $bookingCurrent->getLocatorId(),
                    $bookingCurrent->getServiceId(),
                    $bookingCurrent->getBookingHour(),
                    $bookingCurrent->getDate(),
                    $bookingCurrent->getBookingStatus()
                ),
                'display' => 'none',
                'note' => __('you should choose in order from top to bottom')
            ]
        );

        $fieldSetting->addField(
            'reason',
            'textarea',
            [
                'label' => __('Reason'),
                'name' => 'reason',
                'value' => $bookingCurrent->getReason(),
                'display' => 'none'
            ]
        );

        $this->setChild(
            'form_after',
            $this->getLayout()->createBlock(Dependence::class)
                ->addFieldMap("{$htmlIdPrefix}booking_status", 'booking_status')
                ->addFieldMap("{$htmlIdPrefix}employee_id", 'employee_id')
                ->addFieldMap("{$htmlIdPrefix}reason", 'reason')
                ->addFieldDependence('employee_id', 'booking_status', new Field([
                    'separator'=> ',',
                    'value'=>'1'
                ]))
                ->addFieldDependence('reason', 'booking_status', new Field([
                    'separator'=> ',',
                    'value'=>'2,4'
                ]))
//                ->addFieldDependence('reason', 'booking_status', '4')
        );

//        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
