<?php
/*
********************* GENERA UN ARCHIVO .PDF ******************

........variables necesarioas para el script.........

$sql - Obligatoria - Cadena - Debe contener el query para obtener la informacion que se agregara al archivo pdf

$cabeceras - Obligatoria - Array - Deba contener los nombres de las columnas que se imprimiran

$nombre - Obligatoria - Cadena - Debe contener el nombre del archivo que se generara

$departamento - Obligatoria - Cadena - Indica el departamento al que pertenece el pdf

$tipodocumento - Obligatoria - Cadena - Indica el tipo de documento que es el pdf

$consecutivo - Obligatoria - Numero que distingue el reporte entre los de su departamento

*/

require_once('config/lang/eng.php');
require_once('tcpdf.php');


class PDFP extends TCPDF{
    private $texto = " ";
    private $departamento = " ";
    private $tipodocumento = " ";
    private $consecutivo = " ";
    
    public function setTexto($value){
        $this->texto = $value;
    }
    
    public function setDepartamento($value){
        $this->departamento = $value;
    }
    public function setTipoDocumento($value){
        $this->tipodocumento = $value;
    }
    public function setConsecutivo($value){
        $this->consecutivo = $value;
    }
     //Page header
    public function Header() {
        
        $img_file = K_PATH_IMAGES.'img_portada_carpeta.png';
        $this->Image($img_file, 0, 230, 0,   0, '', '', '', false, 300, '', false, false, 0);
        
        $image_file = K_PATH_IMAGES.'img_logo_portada.jpg';
        $this->Image($image_file, 10, 10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      
        $this->MultiCell(0, 0, $this->texto."   V1.0", 0, 'R', false, 0, '', '', true);
        $this->Ln();
        $this->MultiCell(0, 0, utf8_encode("Código $this->departamento-$this->tipodocumento-$this->consecutivo          "), 0, 'R', false, 0, '', '', true);
        $this->MultiCell(0, 10, "V1.0", 0, 'L', false, 0, '', '', true);
        $image_file = K_PATH_IMAGES.'separador.jpg';
        $this->Image($image_file, 186, 7, 0, '', 'JPG', '', 'R', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', '', 8);
        $this->SetTextColor(88, 89, 91);
        // Page number
        //$this->Cell(0, 10, 'Derechos Reservados                                  www.redefectiva.com                                  Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
      
        $this->Cell(0, 10, utf8_encode("Página ").$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new PDFP(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setTexto(PDF_HEADER_TITLE.$seccion);
$pdf->setDepartamento($departamento);
$pdf->setTipoDocumento($tipodocumento);
$pdf->setConsecutivo($consecutivo);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(PDF_AUTHOR);
$pdf->SetTitle('Reporte PDF');
$pdf->SetSubject('TCPDF ');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.$seccion, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

$pdf->AddPage();

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = K_PATH_IMAGES.'img_portada_carpeta.png';
$pdf->Image($img_file, 0, 230, 0,   0, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();


// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
?>