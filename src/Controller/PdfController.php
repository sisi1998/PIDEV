<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Form\SearchVoyageType;
use App\Form\VoyageTypedate;
use App\Form\SearchVoyageprixType;
use App\Form\VoyageType;
use App\Repository\VoyageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use dompdf\dompdf;
use Dompdf\Options;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;



class PdfController extends AbstractController
{
    public function generatePdf()
    {
        // create a new instance of dompdf
        $dompdf = new dompdf();
        dd($dompdf);

        // set the HTML content
        $html = $this->renderView('pdf/template.html.twig');
        $dompdf->loadHtml($html);

        // render the PDF
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // output the generated PDF to the browser
        $dompdf->stream('document.pdf', [
            'Attachment' => false
        ]);
    }
}