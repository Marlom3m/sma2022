
<?php
 require_once ABSPATH.'controle/atividades.php';
 require_once ABSPATH.'model/atividade.php';
 require_once ABSPATH.'opcoes/Usuario/gridUsuarios.php';
 if($_SESSION['tipo']==1){
    require_once('cdn/fpdf/fpdf.php');
    require_once('model/participante.php');
    $pdf = new FPDF("L","pt","A4");
    $pdf->AddPage();
    
    $usuarios = allUsuariosAtividade($_POST['id_atividade']);
    $texto = mb_strtoupper($usuarios[0]->anome)." - Participantes";
    
    $pdf->SetFont("arial", "B", 16);
	$pdf->SetMargins(40,40,80,40);
	$pdf->MultiCell(0,20, $texto ,0,"C",false);
	$pdf->ln(10);

	$texto = date("d/m/Y",strtotime($usuarios[0]->data))." - ".$usuarios[0]->hora."\nLocal: ".$usuarios[0]->snome;
	$pdf->MultiCell(0,20, $texto ,0,"C",false);
    $pdf->ln(10);
    $pdf->SetFont("arial", "", 12);
    $pdf->Cell(350,15,'Estudante','1',0,'C',0);   // empty cell with left,top, and right borders
    $pdf->Cell(100,15,'CPF',1,0,'C',0);
    $pdf->Cell(300,15,'Assinatura',1,0,'C',0);
	foreach($usuarios as $indice => $usuario){
	    $pdf->ln();
		$pdf->Cell(350,15,mb_strtoupper($usuario->unome),'1',0,'L',0);   // empty cell with left,top, and right borders
        $pdf->Cell(100,15,$usuario->cpf,1,0,'C',0);
        $pdf->Cell(300,15,'',1,0,'L',0);


	}
	$pdf->Output("lista.pdf", "F");
	echo "<script>location.href='lista.pdf';</script>";
 }
	
?>


