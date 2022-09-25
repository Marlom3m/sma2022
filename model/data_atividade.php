<?php
require_once(ABSPATH.'config.php');
require_once DBAPI;
 /**
  * enumeração dos portes
  */
 class DataAtividade extends Database{

   private $id_data_atividade;
   private $data;
   private $hora;
   private $duracao;
   private $fk_atividade;


   function __construct(){
  }
    public function getIdDataAtividade()
    {
        return $this->id_data_atividade;
    }

    public function setIdDataAtividade($id_data_atividade)
    {
        $this->id_data_atividade = $id_data_atividade;
    }


    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    public function getDuracao()
    {
        return $this->duracao;
    }

    public function setDuracao($duracao)
    {
        $this->duracao = $duracao;
    }
    public function getAtividade()
    {
        return $this->fk_atividade;
    }

    public function setAtividade($atividade)
    {
        $this->fk_atividade = $atividade;
    }

    function salvar(){
      $sql = "insert into data_atividade (data, hora, duracao, fk_atividade) values (?,?,?,?)";
      $parametros = array($this->getData(),$this->getHora(),$this->getDuracao(),$this->getAtividade());
      return $this->insertDB($sql,$parametros);
    }
    
    function pesquisaDataAtividade($atributo, $valor){
      $sql = "select * from data_atividade where ".$atributo." = ?";
      $parametros = array($valor);
      $dados = $this->selectDB($sql,$parametros,'DataAtividade');
      if(!empty($dados)){
        $this->setIdDataAtividade($dados[0]->getIdDataAtividade());
        $this->setData($dados[0]->getData());
        $this->setHora($dados[0]->getHora());
        $this->setDuracao($dados[0]->getDuracao());
        $this->setAtividade($dados[0]->getAtividade());
      }
    }


}



 ?>
