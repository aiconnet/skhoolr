<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF { 
	function __construct() { 
		parent::__construct(); 
	}
	
	//Page header
    public function Header() {
        
       // $image_file = K_PATH_IMAGES.'logo_example.jpg';
        $image_file = K_PATH_IMAGES.'logo-avema.jpg';
        $this->Image($image_file, 100, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        //$this->Cell(0, 15, 'AVEMA SECONDARY SCHOOL & VOCATIONAL INSTITUTE', 0, false, 'C', 0, '', 1, true, 'T', 'C');
        //$this->Cell(0, 15, 'P.O. Box 406, Mityana, Uganda', 0, true, 'C', 0, '', 0, true, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
