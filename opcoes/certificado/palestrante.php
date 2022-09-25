<?php
	require_once('cdn/fpdf/fpdf.php');
    require_once('model/palestrante.php');
	$certificado = $_POST['arquivo'];
	$pdf = new FPDF("L","pt","A4");
	$registro = $certificado["'ult_registro'"];
	$folha = $certificado["'pagina'"];
	$pularPagina = $certificado["'linha'"];

	$nome_temporario=$_FILES["arquivo1"]["tmp_name"];
	$nome_real_frente=$_FILES["arquivo1"]["name"];
	copy($nome_temporario,"imagens/$nome_real_frente");

	$nome_temporario=$_FILES["arquivo2"]["tmp_name"];
	$nome_real_verso=$_FILES["arquivo2"]["name"];
	copy($nome_temporario,"imagens/$nome_real_verso");
	$certificados = new palestrante();
	$resultado = $certificados->gerarCertificados(1);
	foreach($resultado as $indice => $result){
		$registro++;
		if($folha){
			$pularPagina++;
			if($pularPagina > $certificado["'reg_pagina'"]){
				$folha++;
				$pularPagina = 1;
			}
		}

        $atividades = $certificados->pegarAtividades($result->id_palestrante);
        
			//Frente do Certificado 1
		$pdf->AddPage();
		$pdf->Image('imagens/'.$nome_real_frente,0,0,$pdf->GetPageWidth(),$pdf->GetPageHeight());
		$pdf->Ln(30);

		$pdf->SetFont("arial", "", 16);
		$pdf->SetY(240);
		$pdf->SetMargins(20,20,40,20);
        
        if(count($atividades)>1){
            $texto = "Certificamos que ".mb_strtoupper($result->pnome). " ministrou as atividades";
        }else{
            $texto = "Certificamos que ".mb_strtoupper($result->pnome). " ministrou a atividade";
        }
		
		$pdf->MultiCell(0,15, $texto,0,"C",false);
		$pdf->Ln(10);
		$nome_anterior = "";
		$total = 0;
		$pdf->SetFont("arial", "B", 16);
		$pdf->Ln(10);
        foreach($atividades as $att => $atividade){
            if($nome_anterior == $atividade->anome){
                $duracao = date_create($atividade->duracao);
		        $duracao = date_format($duracao,"H:i");
		        $v = explode(":",$duracao);
		        $total += $v[0]+$v[1]/60;
            }else{
                $duracao = date_create($atividade->duracao);
		        $duracao = date_format($duracao,"H:i");
		        $v = explode(":",$duracao);
		        $total += $v[0]+$v[1]/60;
		        $pdf->MultiCell(0,15,mb_strtoupper($atividade->anome),0,"C",false);
		        $pdf->ln(10);
            }
            $nome_anterior = $atividade->anome;
            
        }

		
		$pdf->SetFont("arial", "", 14);
		$pdf->Ln(10);

		if($total>1){
		    $texto = "com duração total de ".str_replace(".",",",$total)." horas, durante a ".$result->enome." ".$certificado["'texto'"];
		}else{
		    $texto = "com duração total de ".$total." hora, durante a ".$result->enome." ".$certificado["'texto'"];
		}
		$pdf->MultiCell(0,15,$texto,0,"C",false);
		$pdf->Ln(10);
		
		$data = date_create($certificado["'data'"]);
		$texto4 = $certificado["'campus'"].", MS, ".date_format($data,'d')." de ";
		switch(date_format($data,'m')){
			case '1': $texto4.="janeiro "; break;
			case '2': $texto4.="fevereiro "; break;
			case '3': $texto4.="março "; break;
			case '4': $texto4.="abril "; break;
			case '5': $texto4.="maio "; break;
			case '6': $texto4.="junho "; break;
			case '7': $texto4.="julho "; break;
			case '8': $texto4.="agosto "; break;
			case '9': $texto4.="setembro "; break;
			case '10': $texto4.="outubro "; break;
			case '11': $texto4.="novembro "; break;
			case '12': $texto4.="dezembro "; break;
		}
		$texto4.= "de ".date_format($data,'Y').".";

		$pdf->MultiCell(0,15,$texto4,0,"R",false);
		$pdf->Ln(10);
		$pdf->SetFont("arial", "", "12");

		//Verso do Certificado
		$pdf->addPage();
		$pdf->Image('imagens/'.$nome_real_verso,0,0,$pdf->GetPageWidth(),$pdf->GetPageHeight());
		$pdf->SetMargins(40,20,500,20);
		$pdf->SetX(0);
		$pdf->SetY(140);
		$pdf->Ln(10);
		$pdf->MultiCell(0,15,"Instituto Federal de Educação, Ciência e Tecnologia de Mato Grosso do Sul - IFMS Campus ".$certificado["'campus'"],0,"J",false);
		$pdf->Ln(20);
		$pdf->MultiCell(0,20,"Registro  nº ".$registro,0,"J",false);

		if($folha){
			$pdf->MultiCell(0,20,"Folha ".$folha,0,"J",false);
			$pdf->MultiCell(0,20,"Livro ".$certificado["'livro'"],0,"J",false);
		}else{
			$pdf->Ln(40);
		}

		$pdf->Ln(30);
		$pdf->MultiCell(0,20,$texto4,0,"J",false);

	}
	
	$registro = $certificado["'ult_registro'"];
	$folha = $certificado["'pagina'"];
	$pularPagina = $certificado["'linha'"];
	if($pularPagina < $certificado["'reg_pagina'"]){
	    $pdf->AddPage();
	    $pdf->SetMargins(40,40,80,40);
		$pdf->SetFont("arial", "", 11);
		$pdf->MultiCell(0,20,"Página: ".$folha,0,"R",false);
		$pdf->Ln(10);
        $pdf->Cell(70,15,'Nº Registro','1',0,'C',0);   // empty cell with left,top, and right borders
        $pdf->Cell(80,15,'Evento',1,0,'C',0);
        $pdf->Cell(50,15,'Organiz.',1,0,'C',0);
        $pdf->Cell(350,15,'Participantes',1,0,'C',0);
        $pdf->Cell(60,15,'Assinatura',1,0,'C',0);
        $pdf->Cell(90,15,'Data Retirada',1,0,'C',0);
        $pdf->Cell(50,15,'Cerel',1,0,'C',0);
	}
	foreach($resultado as $indice => $result){
		$registro++;
		if($folha){
			$pularPagina++;
			if($pularPagina > $certificado["'reg_pagina'"]){
				$folha++;
				$pularPagina = 1;
				$pdf->AddPage();
				$pdf->SetMargins(40,40,80,40);
				$pdf->SetFont("arial", "", 11);
				$pdf->MultiCell(0,20,"Página: ".$folha,0,"R",false);
				$pdf->Ln(10);
                $pdf->Cell(70,15,'Nº Registro','1',0,'C',0);   // empty cell with left,top, and right borders
                $pdf->Cell(80,15,'Evento',1,0,'C',0);
                $pdf->Cell(50,15,'Organiz.',1,0,'C',0);
                $pdf->Cell(350,15,'Participantes',1,0,'C',0);
                $pdf->Cell(60,15,'Assinatura',1,0,'C',0);
                $pdf->Cell(90,15,'Data Retirada',1,0,'C',0);
                $pdf->Cell(50,15,'Cerel',1,0,'C',0);
			}
		}
		
		$pdf->ln();
		
	    $pdf->Cell(70,15,$registro,'1',0,'C',0);   // empty cell with left,top, and right borders
        $pdf->Cell(80,15,'SMA 2022',1,0,'C',0);
        $pdf->Cell(50,15,'IFMS',1,0,'C',0);
        $pdf->Cell(350,15,mb_strtoupper($result->pnome),1,0,'L',0);
        $pdf->Cell(60,15,'',1,0,'C',0);
        $pdf->Cell(90,15,'Online',1,0,'C',0);
        $pdf->Cell(50,15,'',1,0,'C',0);

	}

	$pdf->Output("palestrante.pdf", "F");
	header("Location: palestrante.pdf");
	
?>
