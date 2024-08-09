<?php

namespace App\Service;

use App\Entity\Orders;
use Dompdf\Dompdf;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Environment;

class InvoiceService 
{
    public function __construct(private Environment $twig ,private ParameterBagInterface $parameterBag)
    {
    }
    public function generateInvoice (Orders $orders){
        $invoice = $this->twig->render('front/invoice/template.html.twig', [
            'order' => $orders
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($invoice);
        $dompdf->render();
        $dompdf->output();
    }
    public function saveInvoice (Orders $orders , $pdf){

        $fileName = $orders->getOrdersNumber() . '.pdf';
        $fileDir =  $this->parameterBag->get('kernel.project_dir') . '/public/invoices/';
        $filePath = $fileDir . $fileName;

        file_put_contents($filePath, $pdf);
    }
}