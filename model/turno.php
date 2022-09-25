<?php
require_once(ABSPATH.'config.php');
require_once DBAPI;
 /**
  * enumeração dos portes
  */
 class Turno extends Database{

   private $id_turno;
   private $nome;


   function __construct(){
  }
    public function getIdTurno()
    {
        return $this->id_turno;
    }

    public function setIdTurno($id_turno)
    {
        $this->id_turno = $id_turno;
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
      $sql = "insert into turno (nome) values (?)";
      $parametros = array($this->getNome());
      return $this->insertDB($sql,$parametros);
    }

}



 ?>
