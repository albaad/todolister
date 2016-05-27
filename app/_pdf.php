<?php
include_once '../lib/ListerManager.php';
// Import de la classe FPDF
require_once '../fpdf/fpdf.php';

if(!isset($_SESSION['email'])) {
  header('Location:../authentification.php');
}

$db = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
$reader = new ListerManager($db);
$_SESSION['location'] = "Location: index.php";
$email = $_SESSION['email'];
$projects = $reader->projectsList($email);

// Créer une instance de FPDF
$pdf = new FPDF ( 'P', 'mm', 'A4' );
// Ajouter une nouvelles page à notre document
$pdf->AddPage ();
// Fixer la police utilisé pour imprimer les chaînes de caractères
$pdf->SetFont ( 'Open Sans', '', 12 );

$margin = 80;
$nb_prj = 1;

if(!empty($projects)) {

  foreach($projects as $project) {
    if(!$project['done']) {
      $pdf->SetTopMargin ( $margin );
      $pdf->Cell ( 100 + $margin , 10, $project['title'], 0, 1, 'C' );
      $nb_prj++;
      $margin += $margin;

      $list = $reader->readlist($project);
      if(!empty($list)) {

        foreach($list as $item) {
          if(!item['done']) {

            $pdf->

          } else {
            // Item is done, don't print it
          }
        }

      }



    } else {
      // Project is done, we don't print it
    }

  }

}




// Envoyer le document PDF
$pdf->Output ( 'exemple.pdf', 'D' );
