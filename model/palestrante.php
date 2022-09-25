<?php
require_once(ABSPATH.'config.php');
require_once DBAPI;
 /**
  * enumeração dos portes
  */
 class Palestrante extends Database{

   private $id_palestrante;
   private $nome;
   private $email;
   private $instituicao;
   private $foto;
   private $evento;


   function __construct(){
  }
    public function getIdPalestrante()
    {
        return $this->id_palestrante;
    }

    public function setIdPalestrante($id_palestrante)
    {
        $this->id_palestrante = $id_palestrante;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome= $nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    public function getInstituicao()
    {
        return $this->instituicao;
    }

    public function setInstituicao($inst)
    {
        $this->instituicao = $inst;
    }
    
    public function getEvento()
    {
        return $this->evento;
    }

    public function setEvento($evento)
    {
        $this->evento = $evento;
    }

    function salvar(){
      $sql = "insert into palestrante (nome, email, foto, instituicao,  fk_evento) values (?,?,?,?,?)";
      $parametros = array($this->getNome(),$this->getEmail(), $this->getfoto(),$this->getInstituicao(), $this->getEvento());
      return $this->insertDB($sql,$parametros);
    }

    function pesquisaPalestrante($atributo, $valor){
      $sql = "select * from palestrante where ".$atributo." = ?";
      $parametros = array($valor);
      $dados = $this->selectDB($sql,$parametros,'palestrante');
      if(!empty($dados)){
        $this->setIdPalestrante($dados[0]->getIdPalestrante());
        $this->setNome($dados[0]->getNome());
        $this->setEmail($dados[0]->getEmail());
        $this->setfoto($dados[0]->getfoto());
        $this->setInstituicao($dados[0]->getInstituicao());
      }
    }

    function existe($atributo, $valor){
      $sql = "select * from palestrante where ".$atributo." = ?";
      $parametros = array($valor);
      $dados = $this->selectDB($sql,$parametros);
      if(empty($dados)){
        return false;
      }
      return true;
    }

    function allPalestrantes($table, $evento){
      $sql = "select * from ".$table. " where fk_evento = ".$evento." ORDER BY nome";
      $parametros = null;
      return $this->selectDB($sql,$parametros,$table);
    }
    
    function gerarCertificados($evento){
      $sql = "select p.nome as pnome,e.nome as enome, e.inicio, e.final, id_palestrante
              from atividade as a
              join palestrante_atividade as pa ON pa.fk_atividade = a.id_atividade
              join palestrante as p ON p.id_palestrante= pa.fk_palestrante
              join evento as e ON e.id_evento = a.fk_evento
              where a.fk_evento = ?
              GROUP BY id_palestrante
              order by pnome";
      $parametros = array($evento);
      return $this->selectDB($sql,$parametros);
    }
    
    function pegarAtividades($id){
      $sql = "select a.nome as anome, da.duracao
              from atividade as a
              join palestrante_atividade as pa ON pa.fk_atividade = a.id_atividade
              join palestrante as p ON p.id_palestrante= pa.fk_palestrante
              join data_atividade as da ON a.id_atividade = da.fk_atividade
              where p.id_palestrante = ? 
              order by anome";
      $parametros = array($id);
      return $this->selectDB($sql,$parametros);
    }

}



 ?>
