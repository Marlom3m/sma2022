<?php
require_once ABSPATH.'model/usuario.php';

if(!empty($_POST)){
	if (!empty($_POST['id_usuario'])) {
		atualizar();
	}else if(!empty($_POST['nome'])){
		add();
	}else if(!empty($_POST['teste_cpf'])){
		testeCpf();
	}else if(!empty($_POST['senha'])){
		alterarSenha();
	}
}

function add() {
 $usuario = new Usuario();
	$usuario->setNome($_POST['nome']);
  $usuario->setCpf($_POST['cpf']);
	$usuario->setEmail($_POST['email']);
	if(!empty($_POST['ra'])){
		$usuario->setRa($_POST['ra']);
		$usuario->setInstituicao("IFMS");
	}
	if(!empty($_POST['externo']))
		$usuario->setInstituicao($_POST['externo']);
	$usuario->setSenha(password_hash('mudar123', PASSWORD_DEFAULT));
	$usuario->setTipo(2);
	if($usuario->existe('cpf',$usuario->getCpf()) || $usuario->existe('email',$usuario->getEmail())){
	//	$_SESSION['usuario'] = $usuario;
		$_SESSION['message'] = "CPF ou E-MAIL já cadastrados";
		$_SESSION['type'] = 'danger';
	}else if($usuario->salvar()>0){
		$_SESSION['message'] = "Salvo com sucesso <br><h3> Senha Padrão: mudar123</h3>";
		$_SESSION['type'] = 'success';
	}else{
//		$_SESSION['usuario'] = $usuario;
		$_SESSION['message'] = "Erro ao Salvar";
		$_SESSION['type'] = 'danger';
	}
  header('Location: '.BASEURL.'?page=usuario_add'); exit;
}

function atualizar() {
	$usuario = new Usuario();
	$usuario->setNome($_POST['nome']);
	$usuario->setIdUsuario($_POST['id_usuario']);
	$usuario->setCpf($_POST['cpf']);
	$usuario->setEmail($_POST['email']);
	if(!empty($_POST['ra'])){
	    $usuario->setRa($_POST['ra']);
		$usuario->setInstituicao("IFMS");
	}
	if(!empty($_POST['externo']))
		$usuario->setInstituicao($_POST['externo']);
	$user = unserialize($_SESSION['usuario']);
	$usuario->setSenha($user->getSenha());
	$usuario->setTipo($user->getTipo());

	if($usuario->existeOutro('cpf',$usuario->getCpf(),$usuario->getIdUsuario()) || $usuario->existeOutro('email',$usuario->getEmail(),$usuario->getIdUsuario())){
	    $_SESSION['message'] = "CPF ou E-MAIL já cadastrados";
		$_SESSION['type'] = 'danger';
	}else if($usuario->atualizar()>0){
		$_SESSION['message'] = "Atualizado com sucesso <br>";
	    $_SESSION['type'] = 'success';
	}else{
		$_SESSION['message'] = "Erro ao Atualizar - Não alterou nenhum campo";
		$_SESSION['type'] = 'danger';
	}
	header('Location: '.BASEURL.'?page=participante'); exit;
  }

function allUsuarios(){
	$usuarios = new Usuario();
	return $usuarios->participantes($_SESSION['evento']);
}
function total(){
    $participantes = new Usuario();
    $resultado = $participantes->totalpart($_SESSION['evento']);
    return $resultado[0]->total;
}

function testeCpf(){
	$cpf = $_POST['teste_cpf'];
	$usuario = new Usuario();
	$usuario->setCpf($cpf);

	if($usuario->existe('cpf',$usuario->getCpf())){
	    $usuario->pesquisaUsuario("cpf", $cpf);
		$_SESSION['message'] = "CPF já cadastrado realize o LOGIN,\nemail de cadastrado: ". $usuario->getEmail();
	//	$_SESSION['message'] = "CPF já cadastrado realize o LOGIN, caso tenha participado do CONEG/SEAGRO use o mesmo login (".$usuario->getEmail().") e senha do evento";
		$_SESSION['type'] = 'danger';
		header('Location: '.BASEURL.'?page=login'); exit;
	}else{
	//	$_SESSION['usuario'] = $usuario;
		$_SESSION['message'] = "Realize o seu cadastro";
		$_SESSION['type'] = 'warning';
		header('Location: '.BASEURL.'?page=usuario_add'); exit;
	}
}

function alterarSenha(){
	$usuario = unserialize($_SESSION['usuario']);
	if($_POST['senha']==$_POST['confsenha']){
		$usuario->setSenha(password_hash($_POST['senha'], PASSWORD_DEFAULT));
		$usuario->alterarSenha();
		$usuario->pesquisaUsuario('id_usuario', $usuario->getIdUsuario());
		$_SESSION['usuario'] = serialize($usuario);
		$_SESSION['message'] = "Senha alterada com sucesso";
		$_SESSION['type'] = 'success';
	}else{
		$_SESSION['message'] = "Senhas não conferem";
		$_SESSION['type'] = 'danger';
	}
	header('Location: '.BASEURL.'?page=participante'); exit;
}
 ?>
