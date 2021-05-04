<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'dompdf-master/autoload.inc.php';
use Dompdf\Dompdf;

class Mypdf{
    protected $ci;

    public function __construct(){
        $this->ci =& get_instance();
    }

    public function generate($view, $data = [], $filename = 'Laporan', $paper = 'A4', $orientation = 'portrait'){
        $dompdf = new Dompdf();
        $html = $this->ci->load->view($view, $data, TRUE);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper);

        $dompdf->render();
        $dompdf->stream($filename . ".pdf", array("Attachment" => FALSE));
    }
}

?>