<?php
require_once(ABSPATH.'config.php');
require_once DBAPI;
 /**
  * enumeração dos portes
  */
 class Sala extends Database{

   private $id_sala;
   private $nome;


   function __construct(){
  }
    public function getIdSala()
    {
        return $this->id_sala;
    }

    public function setIdSala($id_sala)
    {
        $this->id_sala = $id_sala;
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
      $sql = "insert into sala (nome) values (?)";
      $parametros = array($this->getNome());
      return $this->insertDB($sql,$parametros);
    }
    
    function allSalas($table){
      $sql = "select * from sala order by nome";
      $parametros = null;
      return $this->selectDB($sql,$parametros,$table);
    }

}



 ?>
