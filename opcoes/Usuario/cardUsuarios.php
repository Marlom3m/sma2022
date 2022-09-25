
<?php

 require_once  ABSPATH.'model/usuario.php';


function createCard($usuario)
{
  // colocar a tabela aq

  $card = "<tr>";
  $card = $card . "<td>{$usuario->getIdUsuario()}</td>\n"; //imprime o id do usuario
  $card = $card . "<td>{$usuario->getNome()}</td>\n"; //imprime o Nome do usuario
  $card = $card . "<td>{$usuario->getCpf()}</td>\n"; //imprime o ano do usuario
  $card = $card . "<td>{$usuario->getEmail()}</td>\n"; //imprime o dia inicial do usuario
  $card = $card . "<td>{$usuario->getInstituicao()}</td>\n"; //imprime o Dia final do usuario
  $card = $card . "<td>{$usuario->getRa()}</td>\n"; //imprime o Dia final do usuario
  $card = $card . "<td class='actions text-left'>\n";
 // $card = $card . "<a href='' class='btn btn-sm btn-warning'><i class='fa fa-pencil'></i> Editar</a>\n";
 // $card = $card . "<a href='' class='btn btn-sm btn-danger' data-toggle='modal' data-target='#delete-modal' onclick='deletar()'>\n";
 // $card = $card . "<i class='fa fa-trash'></i> Excluir \n";
//  $card = $card . "</a>\n";
  $card = $card . "</td>\n";
  $card = $card . "</tr>\n";

  return $card;
}

function createCardAtividade($usuario, $i){
  // colocar a tabela aq

  $card = "<tr>";
  $card = $card . "<td>{$i}</td>\n"; //imprime o id do usuario
  $card = $card . "<td>{$usuario->unome}</td>\n"; //imprime o id do usuario
  $card = $card . "<td>{$usuario->cpf}</td>\n"; //imprime o Nome do usuario
  if($usuario->presenca==1){ 
      $card = $card . "<td>Sim</td>\n";
  }else{
      $card = $card . "<td>Nao</td>\n";
  }
  $card = $card . "<td class='actions text-left'>\n";
  $card = $card . "<a href='?page=participante_save&acao=1&a={$usuario->fk_data_atividade}&p={$usuario->fk_participante}' class='btn btn-sm btn-primary p-2 ml-1'>P</a>\n";
  $card = $card . "<a href='?page=participante_save&acao=2&a={$usuario->fk_data_atividade}&p={$usuario->fk_participante}' class='btn btn-sm btn-warning p-2 ml-1'>F</a>\n";
  $card = $card . "<a href='' class='btn btn-sm btn-danger p-2 m-1' data-toggle='modal' data-target='#delete-modal' onclick='deletar("."\"participante_save\",3,{$usuario->fk_data_atividade},{$usuario->fk_participante}".")'>\n";
  $card = $card . "Excluir \n";
  $card = $card . "</a>\n";
  $card = $card . "</td>\n";
  $card = $card . "</tr>\n";

  return $card;
}
 include('modal.php'); 	
 ?>
