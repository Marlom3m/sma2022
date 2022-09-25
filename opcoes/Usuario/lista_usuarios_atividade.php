<script>
    function deletar(page, acao, a, p){
   // window.alert(id);
	$("#confirm").attr("href","?page="+page+"&acao="+acao+"&a="+a+"&p="+p);
}
</script>

<?php
 require_once ABSPATH.'controle/atividades.php';
 require_once ABSPATH.'model/atividade.php';
 require_once ABSPATH.'opcoes/Usuario/gridUsuarios.php';
 if($_SESSION['tipo']==1){
 $usuarios = allUsuariosAtividade($_GET['id_atividade']);
if(!empty($usuarios)){
?>
<div class="text-center h2">
    <?php
        echo mb_strtoupper($usuarios[0]->anome)." - Participantes";
    ?>
</div>
<div class="text-left h5">
    <?php
        echo date("d/m/Y",strtotime($usuarios[0]->data))." - ".$usuarios[0]->hora."<br>Local: ".$usuarios[0]->snome;
    ?>
</div>
<form action="?page=imprimir_lista" method="post">
    <input type=hidden name="id_atividade" value="<?php echo $_GET['id_atividade'];?>">
    <button type="submit" class="btn btn-secondary" formtarget="_blank">Imprimir</button>
</form>
<div class="row border border-white rounded">
<table class="table table-hover table-responsive">
		<thead>
			<tr class="text-center">
			    <th>Nº</th>
				<th>Nome</th>
				<th>Cpf</th>
				<th>Presente</th>
				<th>Ação</th>
			</tr>
		</thead>
		<tbody>

<?php
	echo generateGridAtividades($usuarios);
?>

</div>
<?php
}
 }else{
    header('Location: '.BASEURL.'?page=programacao'); exit;
 }
 /*
echo "\$ve = array(";
$atividades = new Atividade();
$pesquisa = $atividades->atividades();
foreach($pesquisa as $indice => $ativ){
    if(empty($ativ->senha)){
        echo "\"".$ativ->id_atividade." - ".$ativ->nome."@https://projetosifms.com.br/sma2022/index.php?page=participante_save&presenca=".$ativ->id_atividade."\",<br>";
    }
}
echo ");";
*/
/*
$atividades = new Atividade();
$pesquisa = $atividades->atividades();
foreach($pesquisa as $indice => $ativ){
    if(empty($ativ->senha)){
        echo "update data_atividade set qrcode = \"".$ativ->id_atividade." - ".mb_strtoupper($ativ->nome).".pdf\" where id_data_atividade = ".$ativ->id_atividade.";<br>";
    }
}
*/
?>
