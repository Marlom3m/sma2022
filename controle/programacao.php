<?php
require_once ABSPATH.'model/programacao.php';
require_once ABSPATH.'model/participante.php';
require_once ABSPATH.'model/data_atividade.php';

if(!empty($_POST)){
	if(!empty($_POST['atividade'])){
		add();
	}else if(!empty($_POST['desfazer'])){
		remover();
	}
}


function add() {
    $dataAtividade = new DataAtividade();
	$programacao = new Programacao();
    $participante = unserialize($_SESSION['participante']);
    $dataAtividade->pesquisaDataAtividade('fk_atividade', $_POST['atividade']);
    $atividades = $participante->pesquisaAtividades();
    $resultado = false;
    if(!empty($atividades)){
        foreach ($atividades as $indice => $atividade) {
            if($atividade->data == $dataAtividade->getData()){
                $v = explode(":",$atividade->duracao);
                $hora_fcadastrada = date("H:i:s", strtotime("+ ".$v[0]." hours ".$v[1]." minutes ".$v[2]." seconds", strtotime($atividade->hora)));
                $v = explode(":",$dataAtividade->getDuracao());
                $hora_fnova = date("H:i:s", strtotime("+ ".$v[0]." hours ".$v[1]." minutes ".$v[2]." seconds", strtotime($dataAtividade->getHora())));
                if($dataAtividade->getHora()==$atividade->hora || $hora_fcadastrada == $hora_fnova){
                    $resultado = true;
                }else if($dataAtividade->getHora()>$atividade->hora && $dataAtividade->getHora()<$hora_fcadastrada){
                    $resultado = true;
                }else if($hora_fnova>$atividade->hora && $hora_fnova<$hora_fcadastrada){
                    $resultado = true;
                }else if($atividade->hora>$dataAtividade->getHora() && $atividade->hora<$hora_fnova){
                    $resultado = true;
                }else if($hora_fcadastrada>$dataAtividade->getHora() && $hora_fcadastrada<$hora_fnova){
                    $resultado = true;
                }
            }
        }
    }
    if($resultado){
        $_SESSION['message'] = "Esta atividade conflita com o horário de outra atividade inscrita";
	    $_SESSION['type'] = 'danger';
    }else if($_POST['limite']==0){
        $programacao->salvarParticipacao($_POST['atividade'],$participante->getIdParticipante());
	    $_SESSION['message'] = "Atividade adicionada com sucesso";
	    $_SESSION['type'] = 'success';
    }else{
        $inscritos = $programacao->numeroInscritos($_POST['atividade']);
        if($_POST['limite']-$inscritos[0]->total > 0){
            $programacao->salvarParticipacao($_POST['atividade'],$participante->getIdParticipante());
        	$_SESSION['message'] = "Atividade adicionada com sucesso";
        	$_SESSION['type'] = 'success';
        }else{
            $_SESSION['message'] = "Limite excedido";
        	$_SESSION['type'] = 'danger';
        }
    }
    $retorno = null;
    //ARRUMAR DEPOIS PARA QUALQUER DATA
	if($dataAtividade->getData() == "2022-10-05"){
	    $retorno = 0;
	}else if($dataAtividade->getData() == "2022-10-06"){
	    $retorno = 1;
	}else{
	    $retorno = 2;
	}
  header('Location: '.BASEURL.'?page=programacao&pagina='.$retorno);exit;
}

function remover(){
    $dataAtividade = new DataAtividade();
	$programacao = new Programacao();
    $participante = unserialize($_SESSION['participante']);
	$programacao->deletarParticipacao($_POST['desfazer'],$participante->getIdParticipante());
	$dataAtividade->pesquisaDataAtividade('fk_atividade', $_POST['desfazer']);
	$_SESSION['message'] = "Atividade removida com sucesso";
	$_SESSION['type'] = 'success';
	//ARRUMAR DEPOIS PARA QUALQUER DATA
	$retorno = null;
	if($dataAtividade->getData() == "2022-10-05"){
	    $retorno = 0;
	}else if($dataAtividade->getData() == "2022-10-06"){
	    $retorno = 1;
	}else{
	    $retorno = 2;
	}
  header('Location: '.BASEURL.'?page=programacao&pagina='.$retorno);exit;
}

?>
