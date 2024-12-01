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

// create new PDF document
$pdf = new PDFP(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$pdf->setTexto(PDF_HEADER_TITLE.$seccion);
$pdf->setTexto($seccion);

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

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.

if($seccion == "Cortes")
    $pdf->SetFont('dejavusans', '', 8.5, '', true);
else
    $pdf->SetFont('dejavusans', '', 4, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
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
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

//Logica para la informacion que se mostrara
$d = "<style>
	    table {
		    width:100%;
		    color: #003300;		    		    
		    float:left;
		}
		th{
		    text-align:center;
		    color: #3399ff;
		    font-size:24px;
		    border-bottom:1px solid #999;
		    float:left;
		}
		td{
		    text-align:left;
		    border-bottom:1px solid #999;
		    font-size:22px;
		    float:left;
		}
		.divDividerX{
			margin: 0px auto 0px auto;
			padding: 0px 0px 0px 0px;
			width:100%; border-bottom:1px solid #BBB; border-top:1px solid #CCC; height:0px;
		}
	    </style>";		
if ( $seccion == "Cortes" || $seccion == "Comisiones" || $seccion == "PreCadena"
	|| $seccion == "Proveedores" || $seccion == "Reporte de Alta de Cadena" || $seccion == "Reporte de Alta de Subcadena"
	|| $seccion == "Reporte de Alta de Corresponsal" ) {
	$html = utf8_encode($data);
}

else{
	$res = $RBD->query($sql);
    if($RBD->error() == ''){
        if(mysqli_num_rows($res) > 0 && count($cabeceras) > 0){                          
			$d.= "<table border='0' cellspacing='0' cellpadding='0'><tr>";
            for($i = 0; $i < count($cabeceras); $i++)
                $d.="<th>$cabeceras[$i]</th>";
            $d.="</tr>";
         	            
            if($seccion == "Sucursales"){
                //CONSULTAR Y PASAR LAS ENTIDADES A UN ARREGLO
                $entidades = array();
                $sql = "CALL `prealta`.`SP_LOAD_ESTADOS`(164);";
				$rows = $RBD->query($sql);
                while($row = mysqli_fetch_array($rows)){
                    $entidades[] = $row;
                }
                //CONSULTAR Y PASAR LAS VERSIONES A UN ARREGLO
                $versiones = array();
				$sql = "CALL `prealta`.`SP_LOAD_VERSIONES`();";
                $rows = $RBD->query($sql);
                while($row = mysqli_fetch_array($rows)){
                    $versiones[] = $row;
                }
                //AGREGAR DATOS A LA TABLA
                
                while(list($id,$nomb,$version,$ident,$ciudad,$direccion,$telefono) = mysqli_fetch_array($res)){
                   $d.="<tr><td>$id</td><td>$nomb</td><td>";
                    $i = 0;
                    while($i < count($versiones)){
                        if($versiones[$i][0] == $version){
                            $d.= $versiones[$i][1];
                            break;
                        }
                        $i++;
                    }
                    $d.="</td><td>";
                    $i = 0;
                    while($i < count($entidades)){
                        if($entidades[$i][0] == $ident){
                            $d.= $entidades[$i][1];
                            break;
                        }
                        $i++;
                    }
                 $d.="</td><td>$ciudad</td><td>$direccion</td><td>$telefono</td></tr>";
                }
                
            }else if($seccion == "Operaciones"){
                 while($r = mysqli_fetch_array($res)){
                    $d.="<tr>";
                    for($j = 0; $j < count($cabeceras); $j++){
                        if($j < count($cabeceras) -1)
                            $d.="<td>$r[$j]</td>";
                        else
                            $d.="<td>$".number_format($r[$j],2)."</td>";
                    }
                                        
                    $d.="</tr>";
                }
            }else{
                while($r = mysqli_fetch_array($res)){
                    $d.="<tr>";
                    for($j = 0; $j < count($cabeceras); $j++)
                        $d.="<td>$r[$j]</td>";
                    $d.="</tr>";
                }
            }
            $d.="</table>";
        }else{
            $d = "<span style='color:#f00;'>Lo Sentimos Pero No Se econtraron Operaciones Para Este Corresponsal...</span>";
        }
    }else{
        $d.="Error al realizar la consulta: ".$RBD->error();
        $d.="<br />".$sql;
    }
    $html = utf8_encode($d);
}

// Set some content to print
/*$html = <<<EOF


EOF;*/
//$html = $sql;

//echo $sql;
//echo $html;
// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('CrearPDF.pdf', 'I');
?>