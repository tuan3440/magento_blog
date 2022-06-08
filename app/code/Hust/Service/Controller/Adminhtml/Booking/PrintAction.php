<?php

namespace Hust\Service\Controller\Adminhtml\Booking;

use Hust\Service\Controller\Adminhtml\Booking;
use Hust\Service\Block\Adminhtml\Booking\Pdf;

class PrintAction extends Booking
{
   public function execute()
   {
       $booking = $this->getRequest()->getParam("booking");
       $mpdf = new \Mpdf\Mpdf();
       $content = "";
       $blockPdf = $this->_view->getLayout()->createBlock(Pdf::class)
           ->setTemplate("Hust_Service::booking/invoice.phtml")
           ->assign("booking", $booking);
       $content .= $blockPdf->toHtml();
       $mpdf = new \Mpdf\Mpdf([
               'tempDir' => '/tmp',
               'mode' => 'utf-8',
               'format' => 'A4',
               'default_font' => 'Arial',
               'orientation' => 'P',
               'margin_left' => 0,
               'margin_right' => 0,
               'margin_top' => 0,
               'margin_bottom' => 0,
               'margin_header' => 0,
               'margin_footer' => 0,
           ]
       );
       $mpdf->SetDisplayMode('fullpage');
       $mpdf->WriteHTML($content);
       $mpdf->Output();
   }
}
