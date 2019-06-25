<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;


class Pdfgenerator {
  public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {


    $options = new Options();
    // $options->setIsRemoteEnabled(true);
    $options->set('tempDir', __DIR__ . '/site_uploads/dompdf_temp');
    $options->set('isRemoteEnabled', TRUE);
    $options->set('debugKeepTemp', TRUE);
    $options->set('chroot', '/'); // Just for testing :)
    $options->set('isHtml5ParserEnabled', true);

    $dompdf = new DOMPDF($options);
    $contxt = stream_context_create([
    'ssl' => [
        'verify_peer' => FALSE,
        'verify_peer_name' => FALSE,
        'allow_self_signed'=> TRUE
    ]
]);
$dompdf->setHttpContext($contxt);
    // $dompdf->setOptions($options);
    $dompdf->load_html($html);
    $dompdf->set_paper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => 0));
    } else {
        return $dompdf->output();
    }
  }
}
