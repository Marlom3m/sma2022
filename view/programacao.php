<?php
require_once ABSPATH.'model/programacao.php';
require_once ABSPATH.'model/participante.php';

$programacao = new Programacao();
//FAZER PESQUISA NO BANCO DE TODAS AS DATAS;
$data = array('01/06','02/06','03/06');
$pagina=null;
if(!empty($_GET['pagina'])){
    if($_GET['pagina']==0){
        $programacoes = $programacao->getProgramacaoData($_SESSION['evento'],'2022-06-01');
        $pagina = 0;
    }else if($_GET['pagina']==1){
        $programacoes = $programacao->getProgramacaoData($_SESSION['evento'],'2022-06-02');
        $pagina = 1;
    }else if($_GET['pagina']==2){
        $programacoes = $programacao->getProgramacaoData($_SESSION['evento'],'2022-06-03');
        $pagina = 2;
    }
}else{
    $programacoes = $programacao->getProgramacaoData($_SESSION['evento'],'2022-06-01');
    $pagina = 0;
}
/* TROCAR POR ESSE DEPOIS DE ARRUMADO
if(!empty($_GET['pagina'])){
    $programacoes = $programacao->getProgramacaoData($_SESSION['evento'],$data[$_GET['pagina']]);
    $pagina = $_GET['pagina'];
}else{
    $programacoes = $programacao->getProgramacaoData($_SESSION['evento'],'2022-06-01');
    $pagina = 0;
}
*/

date_default_timezone_set ('America/Cuiaba');
$hojeDia = date("Y-m-d");
?>

<div class="container col-md-5" >
  <?php
    if (!empty($_SESSION['type'])) {
  ?>
  <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php
      if(!empty($_SESSION['message']))
        echo $_SESSION['message'].'<br>';
    ?>
  </div>
  <?php
    unset($_SESSION['type']);
    unset($_SESSION['message']);
  }
  ?>
</div>
<br>

<div class="container ">
<div class="row align-items-stretch d-flex justify-content-center">
<div class="col-5 border pt-3 mr-2" style="background-color: #e3fbe3">

     <h6 class="p-2 text-white text-center" style="background-color: #04622e" >CONCURSO DE FRASES SOBRE O MEIO AMBIENTE</h6>
     <h6 class="p-2 text-center">Faça a Inscrição e o Envio da frase até o dia 02/06/2022</h6>

     <?php
     echo $hojedia;
     if(date("Y-m-d", strtotime($hojeDia))<'2022-06-03'){
     ?>
    <div class=" d-flex justify-content-center text-center" >
       <a href="https://forms.gle/SB7tDQqXFM3SKMJw5" target="_blank"> <button class="btn text-white font-weight-bold p-1" style="background-color: #73b61c">Inscrição/Envio</button></a>
     </div>
    <?php
     }else{
         echo "<h6 class='p-2 text-center'>Encerrado</h6>";
     }
     ?>
</div>
<div class="col-6 border pt-3 ml-3" style="background-color: #e3fbe3">
     <h6 class="p-2 text-white text-center" style="background-color: #04622e" >MÊS DA COLETA SELETIVA</h6>
     <h6 class="pt-2 text-center">Deposite as latinhas de alumínio e garrafas pet nos cestos corretos.<br>Nesse mês coletaremos diariamente esses resíduos para quantificar o volume produzido e o valor que desperdiçamos quando não reciclamos esse material.</h6>
     <h6 class="p text-center">Responsáveis: Rayner, Aryane, Pedro e Denise</h6>
</div>
</div>
</div>
<br>
<nav aria-label="Dias do Evento">
  <ul class="pagination pagination-lg justify-content-center">
    <?php
		for($i=0;$i<count($data);$i++){
			$estilo = "";
			$cor_texto = "style='color: #04622e'";
			if($pagina == $i || $pagina == null && $i==0){
				$estilo = "disabled";
				$cor_texto = "style='color: #73b61c'";
			}
			//Mudar a forma de aparecer a data, de acordo com o array que irá chegar do banco.
			echo "<li class='page-item $estilo'  ><a class='page-link' $cor_texto href='?page=programacao&pagina=$i'>$data[$i]</a></li>";
		}
     ?>
  </ul>
</nav>

<?php
foreach($programacoes as $indice => $programa){
  $palestrantes = $programacao->getPalestrantes($programa->id_atividade);
?>
<div class="container border bg-white pt-3">
    <?php
        $inscritos = $programacao->numeroInscritos($programa->id_data_atividade);
        $vagas = $programa->limite-$inscritos[0]->total;
    ?>
  <div class="row align-items-center">
     <div class="col-12" >
         <h5 class="p-2 text-white text-center" style="background-color: #04622e" ><?php echo mb_strtoupper($programa->nomea);?></h5>
     </div>
     <?php
        if($_SESSION['tipo']==1){
     ?>
        <div class="col-12 text-right">
        <a href="?page=usuarios_atividade&id_atividade=<?php echo $programa->id_data_atividade;?>">VER INSCRITOS</a>
        </div>
        <div class="col-12 text-right">
        <h6><?php if(!empty($programa->senha)) {echo "Senha: ".$programa->senha;} ?></h6>
        </div>
        <div class="col-12 text-right">
         <?php if(!empty($programa->qrcode)) {  ?>
        <h6><a href="https://projetosifms.com.br/sma2022/imagens/qrcode/<?php echo $programa->qrcode; ?>" target="_blank">QRCODE</a></h6>
        <?php } ?>
        </div>
     <?php
        }
     ?>
    <div class="col-7">
      
      <h6><?php echo $programa->descricao;?></h6>
      <?php
        if($programa->nomes !="Youtube" && $programa->nomes !="Google Meet"){
      ?>
        <h6 class="font-italic"><?php if(isset($programa->observacao)){echo $programa->observacao;}?></h6>
      <?php
        }
      $v = explode(":",$programa->duracao);
      $hora_final = date("H:i", strtotime("+ ".$v[0]." hours ".$v[1]." minutes ".$v[2]." seconds", strtotime($programa->hora)));
      ?>
      <h6 class="font-weight-bold"><?php echo "Data: ".date("d/m", strtotime($programa->data))." - ".date("H:i", strtotime($programa->hora))." às ".$hora_final." hs";?></h6>
      <?php
        if($programa->nomes !="Youtube" && $programa->nomes !="Google Meet"){
      ?>
      <h6>Local: <?php echo $programa->nomes;?></h6>
      <?php
        }else{
      ?>
        <h6>Local: <a href="<?php echo $programa->observacao; ?>" target=_blank><?php echo $programa->nomes;?></a></h6>
      <?php
        }
      ?>
      <h6> Vagas: <?php if($programa->limite==0) echo "ilimitada"; else echo $vagas;?></h6>
      
    </div>
    <?php
     if($hojeDia<=$programa->data){
      if(!empty($_SESSION['participante'])){
        $participante = unserialize($_SESSION['participante']);
        if(empty($programacao->verificaAtividade($programa->id_data_atividade,$participante->getIdParticipante()))){
            if($vagas>0 || $programa->limite == 0){
    ?>
    <div class="col-4 justify-content-center text-center">
      <form action="?page=programacao_save" method="post">
    		<div class="row">
    			<div class="col-md-12">
            <input type="hidden" class="form-control" name="atividade" value="<?php echo $programa->id_data_atividade;?>">
            <input type="hidden" class="form-control" name="limite" value="<?php echo $programa->limite;?>">
    				<button type="submit" class="btn text-white font-weight-bold " style="background-color: #73b61c">Inscrever</button>
    			</div>
    		</div>
    	</form>
    </div>
    <?php
      }else{
    ?>
        <div class=" col-4 justify-content-center text-center">
        <p class="text-center m-2">Vagas preenchidas</p>
     </div>
    <?php
      }
      }else{
    ?>
    <div class="col-4 justify-content-center text-center">
      <form action="?page=programacao_save" method="post">
    		<div class="row">
    			<div class="col-md-12">
            <input type="hidden" class="form-control" name="desfazer" value="<?php echo $programa->id_data_atividade;?>">
    				<button type="submit" class="btn btn-secondary">Cancelar <br> Participação</button>
    			</div>
    		</div>
    	</form>
    </div>
    <?php
      }
    }else{
     ?>

     <div class="col-4 justify-content-center text-center">
       <h6>Faça a inscrição para participar</h6>
     </div>

     <?php
     }
   }

      ?>
      <div class="col-12 mb-2">
      <!--<h5 class="text-center"><?php if(count($palestrantes)>1){echo "Ministrado por: ";}else{echo "Ministrado por: ";} ?></h5>-->
      <h6 class="text-center font-weight-bold">Ministrado por:</h6>
      <?php
        foreach($palestrantes as $indice => $palestrante){
       ?>
      <h6 class="font-italic text-center"><?php echo $palestrante->nome; if(isset($palestrante->instituicao)){echo " (".$palestrante->instituicao.")";}?></h6>
      <?php
        }
       ?>
  </div>
  </div>
  
 <!-- <div class="row align-items-center">
    <?php
      foreach($palestrantes as $indice => $palestrante){
     ?>
    <img class="col-2 rounded-circle"  src="<?php echo $palestrante->foto; ?>"><br>
    <?php
      }
     ?>
   </div> -->
</div>
<br>

<?php
}
if($pagina==2){
?>
<div class="container ">
<div class="row align-items-center">
<div class="col-12 border  pt-3 mr-2" style="background-color: #e3fbe3">

     <h5 class="p-2 text-white text-center" style="background-color: #04622e" >ENCERRAMENTO E PREMIAÇÃO DO CONCURSO DE FRASES</h5>
     <h6>Encerramento - Semana do Meio Ambiente 2022</h6>
     <h6 class="font-weight-bold">Data: 03/06 - 19:00 às 20:00 hs</h6>
      <h6>Local: <a href="https://www.youtube.com/watch?v=Kq4mms4qFeI">Youtube</a></h6>
      <h6> Vagas: Ilimitado</h6>
      <h6 class="text-center font-weight-bold">Ministrado por:</h6>
      <h6 class="font-italic text-center">Izidro dos Santos de Lima Junior (DIRGE IFMS-PP)</h6>
    <h6 class="font-italic text-center">Ligia Maria Maraschi da Silva Piletti (DIREN IFMS-PP)</h6>
    <h6 class="font-italic text-center">Marcelo Rigotti  (IFMS-PP)</h6>
</div>
</div>
</div>
<br>
<?php
}
?>
<?php
if($pagina==1){
?>
<div class="container ">
<div class="row align-items-center">
<div class="col-12 border  pt-3 mr-2" style="background-color: #e3fbe3">

     <h5 class="p-2 text-white text-center" style="background-color: #04622e" >EXPOSIÇÃO DE PRODUTOS DAS MULHERES EMPREENDEDORAS</h5>
     <h6>Exposição</h6>
     <h6 class="font-weight-bold">Data: 02/06 - 19:00 às 22:00 hs</h6>
     <!-- <h6>Local: Youtube</h6>
      <h6> Vagas: Ilimitado</h6> -->
      <h6 class="text-center font-weight-bold">Ministrado por:</h6>
      <h6 class="font-italic text-center">Mulheres empreendedoras</h6>
</div>
</div>
</div>
<br>
<?php
}
?>
<nav aria-label="Dias do Evento">
  <ul class="pagination pagination-lg justify-content-center">
    <?php
		for($i=0;$i<count($data);$i++){
			$estilo = "";
			$cor_texto = "style='color: #04622e'";
			if($pagina == $i || $pagina == null && $i==0){
				$estilo = "disabled";
				$cor_texto = "style='color: #73b61c'";
			}
			//Mudar a forma de aparecer a data, de acordo com o array que irá chegar do banco.
			echo "<li class='page-item $estilo'  ><a class='page-link' $cor_texto href='?page=programacao&pagina=$i'>$data[$i]</a></li>";
		}
     ?>
  </ul>
</nav>