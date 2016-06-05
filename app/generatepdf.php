<?php
  require 'lib/PDF.class.php';

  function encode($utf8) {
    return iconv('UTF-8', 'windows-1252', $utf8);
  }

if (!isset($_SESSION['email'])) {
  if(isset($_SESSION['location'])) {
    header($_SESSION['location']);
  } else {
    header('Location:../authentification.php');
  }
}

  // Connect to DB and get project list
	$email= $_POST['email'];

  $db = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
  $reader = new ListerManager($db);
  $_SESSION['location'] = "Location: index.php";
  $email = $_SESSION['email'];
  $projects = $reader->projectsList($email);


  // Create a PDF object
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$pdf->SetMargins(20, 20, 20);


  if(!empty($projects)) { // If user has any projects

    foreach($projects as $project) {
      // Project title
      $pdf->SetFont('Arial', '', 12);
      $pdf->Ln(10);
      $pdf->Cell(0, 6, encode($project['title']), 0, 1);

    	$pdf->SetWidths(array(100, 45, 55, 50, 20));
    	$pdf->SetFont('Arial', '', 10);
      $pdf->SetFillColor(82, 95, 108);
      $pdf->SetTextColor(255);

      for($i=0;$i<1;$i++) {
        $complete = iconv('UTF-8', 'windows-1252', 'COMPLÉTÉ'); // Standard FPDF fonts use ISO-8859-1 or Windows-1252
        $pdf->SetAligns(array('C', 'C', 'C', 'C')); // set align center for all table headers
    		$pdf->Row(array('NOM', encode('COMPLÉTÉ'), 'DATE AJOUT', 'DATE FINI'));
      }

      // Get item list of corresponding project
      $project_id = $project['id'];
      $items = $reader->readList($project_id);

      if(!empty($items)) { // If project as any items

        foreach($items as $item) {
          // Set font settings for item row
          $pdf->SetFont('Arial', '', 10);
          $pdf->SetFillColor(190, 193, 196);
          $pdf->SetTextColor(0);
          // Print item as table row
          $pdf->SetAligns(array('L', 'C', 'C', 'C'));
          $done = ($item['done'] == 1) ? 'OUI' : 'NON';
          $completed = ($item['done'] == 1) ? $item['completed'] : '-';
          $pdf->Row(array(encode($item['name']), $done, $item['created'], $completed));
        }

      } else {
        $pdf->SetFillColor(190, 193, 196);
        $pdf->SetTextColor(0);
        $pdf->Row(array(encode('*AUCUNE TÂCHE*'), '-', '-', '-'));
      }

    } // end foreach projects

  } else {
    $pdf->SetFont('Arial', '', 12);
    $line = iconv('UTF-8', 'windows-1252', '*Aucun projet ajouté*');
    $pdf->Cell(0, 6, $line, 0, 1, 'C');
  }

  // PDF file name: 'ToDoLister_DD/MM/YYYY.pdf'
  $today = date('d-m-Y');
  $filename = 'ToDoLister_'.$today.'.pdf';

  // Send PDF
  $pdf->Output('I', $filename);

?>
