<?php
require_once ABSPATH.'model/participante.php';
require_once ABSPATH.'model/atividade.php';
require_once ABSPATH.'model/programacao.php';

if(!empty($_POST)){
	if(!empty($_POST['participante'])){
		add();
	}else if(!empty($_POST['presenca'])){
		salvarPresenca($_POST['presenca']);
	}
}else if(!empty($_GET['presenca'])){
		salvarPresencaGet($_GET['presenca']);
}else if(!empty($_GET['acao'])){
    if($_GET['acao']==1){
        salvarPresencaAdmin();
    }else if($_GET['acao']==2){
        removerPresencaAdmin();
    }else{
        excluirParticipante();
    }
}


function add() {
  $participante = new Participante();
	$participante->setUsuario($_POST['participante']);
	if(!empty($_POST['turno']))
		$participante->setTurno($_POST['turno']);
	if(!empty($_POST['turma']))
		$participante->setTurma($_POST['turma']);
	if($participante->salvar($_SESSION['evento'])>0){
		$_SESSION['participante'] = serialize($participante->pesquisaParticipante($_SESSION['evento'],$participante->getUsuario()));
		$_SESSION['message'] = "Salvo com sucesso";
		$_SESSION['type'] = 'success';
	}else{
		$_SESSION['message'] = "Erro ao Salvar";
		$_SESSION['type'] = 'danger';
	}
  header('Location: '.BASEURL.'?page=participante');exit;
}

function allparticipantes(){
	$participantes = new participante();
	return $participantes->all('participante');
}

function salvarPresenca($idAtividade){
	$participante = unserialize($_SESSION['participante']);
	$atividade = new atividade();
	$resultado = $atividade->buscarSenha($idAtividade);
	if($_POST['codigo']==$resultado[0]->senha){
		$participante->registraPresenca($idAtividade);
	}else{
		$_SESSION['message'] = "Código Inválido";
		$_SESSION['type'] = 'danger';
	}
	header('Location: '.BASEURL.'?page=participante');exit;
}

function salvarPresencaGet($idAtividade){
	$participante = unserialize($_SESSION['participante']);
	if($idAtividade==$_SESSION['id_atividade']){
	    $participante->registraPresenca($idAtividade);
	}else{
	    $_SESSION['message'] = "Esse QrCode não é da atividade selecionada";
		$_SESSION['type'] = 'danger';
	}
	header('Location: '.BASEURL.'?page=participante');exit;
}

function salvarPresencaAdmin(){
	$participante = new Participante();
	$participante->registraPresencaAdmin($_GET['a'],$_GET['p']);
	header('Location: '.$_SERVER['HTTP_REFERER']);exit;
}

function removerPresencaAdmin(){
	$participante = new Participante();
	$participante->removerPresencaAdmin($_GET['a'],$_GET['p']);
	header('Location: '.$_SERVER['HTTP_REFERER']);exit;
}

function excluirParticipante(){
	$programacao = new Programacao();
	$programacao->deletarParticipacao($_GET['a'],$_GET['p']);
	header('Location: '.$_SERVER['HTTP_REFERER']);exit;
}

?>
