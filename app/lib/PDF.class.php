<?php
require 'fpdf/fpdf.php';
include_once '../lib/ListerManager.php';

class PDF extends FPDF {
  var $widths;
  var $aligns;

  function SetWidths($w) {
    //Set the array of column widths
    $this->widths = $w;
  }

  function SetAligns($a) {
    //Set the array of column alignments
    $this->aligns = $a;
  }

  function Row($data) {
    //Calculate the height of the row
    $nb = 0;
    for($i = 0; $i < count($data); $i++) { $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i])); }
    $h = 5 * $nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i = 0; $i < count($data); $i++) {
      $w = $this->widths[$i];
      $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
      //Save the current position
      $x = $this->GetX();
      $y = $this->GetY();
      //Draw the border
      $this->Rect($x,$y,$w,$h);

      $this->MultiCell($w, 5, $data[$i], 0, $a,'true');
      //Put the position to the right of the cell
      $this->SetXY($x + $w, $y);
    }
    //Go to the next line
    $this->Ln($h);
  }

  function CheckPageBreak($h) {
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY() + $h > $this->PageBreakTrigger)
      $this->AddPage($this->CurOrientation);
  }

  function NbLines($w, $txt) {
    //Computes the number of lines a MultiCell of width w will take
    $cw = &$this->CurrentFont['cw'];
    if($w == 0) { $w = $this->w - $this->rMargin - $this->x; }
    $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
    $s = str_replace("\r", '', $txt);
    $nb = strlen($s);
    if($nb > 0 and $s[$nb - 1] == "\n") { $nb--; }
    $sep = -1; $i = 0; $j = 0; $l = 0; $nl = 1;
    while($i < $nb) {
      $c = $s[$i];
      if($c == "\n") {
        $i++; $sep = -1; $j = $i; $l = 0; $nl++;
        continue;
      }
      if($c == ' ') { $sep = $i; }
      $l += $cw[$c];
      if($l > $wmax) {
        if($sep == -1) { if($i == $j) { $i++; } }
        else { $i = $sep + 1; }
        $sep = -1; $j = $i; $l = 0; $nl++;
      }
      else{ $i++; }
    } //end while
    return $nl;
  }

  function Header() {
    $this->Image("../img/logo.png", 10, 10, 47, 9, "PNG");
    $this->SetFont('Helvetica', 'B', 12);
    $this->SetTextColor(22, 170, 86);
    $this->Text(70, 17, $_SESSION['email'], 0, 'C', 0);
    $this->Ln(30);
  }

  function Footer() {
    $this->SetY(-15);
    $this->SetFont('Arial', '', 8);
    date_default_timezone_set("Europe/Paris");
    $date = date('d/m/Y H:i:s');
    $this->Cell(100, 10, $date, 0, 0, 'L');
  }

}
