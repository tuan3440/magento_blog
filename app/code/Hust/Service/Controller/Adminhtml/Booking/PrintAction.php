<?php

namespace Hust\Service\Controller\Adminhtml\Booking;

use Hust\Service\Controller\Adminhtml\Booking;
use Hust\Service\Block\Adminhtml\Booking\Pdf;

class PrintAction extends Booking
{
   public function execute()
   {
       $bookingId = $this->getRequest()->getParam("booking");
       $mpdf = new \Mpdf\Mpdf();
       $content = "";
       $blockPdf = $this->_view->getLayout()->createBlock(Pdf::class)
           ->setTemplate("Hust_Service::booking/invoice.phtml")
           ->assign("bookingId", $bookingId);
       $content .= $blockPdf->toHtml();
       $mpdf = new \Mpdf\Mpdf([
               'tempDir' => '/tmp',
               'mode' => 'utf-8',
               'format' => 'A4',
               'default_font' => 'Arial',
               'orientation' => 'P',
               'margin_left' => 20,
               'margin_right' => 20,
               'margin_top' => 20,
               'margin_bottom' => 20,
               'margin_header' => 20,
               'margin_footer' => 20,
           ]
       );
       $mpdf->showImageErrors = true;
       $mpdf->SetDisplayMode('fullpage');
       $mpdf->WriteHTML($content);
       $mpdf->Output();
   }
}
