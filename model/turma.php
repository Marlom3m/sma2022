<?php
require_once(ABSPATH.'config.php');
require_once DBAPI;
 /**
  * enumeração dos portes
  */
 class Turma extends Database{

   private $id_turma;
   private $nome;


   function __construct(){
  }
    public function getIdTurma()
    {
        return $this->id_turma;
    }

    public function setIdTurma($id_turma)
    {
        $this->id_turma = $id_turma;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome= $nome;
    }

    function salvar(){
      $sql = "insert into turma (nome) values (?)";
      $parametros = array($this->getNome());
      return $this->insertDB($sql,$parametros);
    }

}



 ?>
