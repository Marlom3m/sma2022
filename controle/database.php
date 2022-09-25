<?php
abstract class Database{
    /*Método construtor do banco de dados*/
    private function __construct(){}

    /*Evita que a classe seja clonada*/
    private function __clone(){}

    /*Método que destroi a conexão com banco de dados e remove da memória todas as variáveis setadas*/
    public function __destruct() {
        $this->disconnect();
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    private static $dbtype   = "mysql";
    private static $host     = "localhost";
    private static $port     = "3306";
    private static $user     = "root";
      private static $password = "";
      private static $db       = "sma";
  /*  private static $user     = "u411879655_sisnovo";
    private static $password = "Sisnovo1";
    private static $db       = "u411879655_sisnovo";*/

    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada*/
    private function getDBType()  {return self::$dbtype;}
    private function getHost()    {return self::$host;}
    private function getPort()    {return self::$port;}
    private function getUser()    {return self::$user;}
    private function getPassword(){return self::$password;}
    private function getDB()      {return self::$db;}

    private function connect(){
        try
        {
            $this->conexao = new PDO($this->getDBType().":host=".$this->getHost().";port=".$this->getPort().";dbname=".$this->getDB(), $this->getUser(), $this->getPassword());
        }
        catch (PDOException $i)
        {
            //se houver exceção, exibe
            die("Erro: <code>" . $i->getMessage() . "</code>");
        }

        return ($this->conexao);
    }

    private function disconnect(){
        $this->conexao = null;
    }

    /*Método select que retorna um VO ou um array de objetos*/
    public function selectDB($sql,$params=null,$class=null){
        $query=$this->connect()->prepare($sql);
        $query->execute($params);
        if(isset($class)){
            $rs = $query->fetchAll(PDO::FETCH_CLASS,$class);
        }else{
            $rs = $query->fetchAll(PDO::FETCH_OBJ);
        }
        self::__destruct();
        return $rs;
    }

    /*Método insert que insere valores no banco de dados e retorna o último id inserido*/
    public function insertDB($sql,$params=null){
        $conexao=$this->connect();
        $query=$conexao->prepare($sql);
        $query->execute($params);
        $rs = $conexao->lastInsertId();
        self::__destruct();
        return $rs;
    }

    /*Método update que altera valores do banco de dados e retorna o número de linhas afetadas*/
    public function updateDB($sql,$params=null){
        $query=$this->connect()->prepare($sql);
        $query->execute($params);
        $rs = $query->rowCount();
        self::__destruct();
        return $rs;
    }

    /*Método delete que excluí valores do banco de dados retorna o número de linhas afetadas*/
    public function deleteDB($sql,$params=null){
        $query=$this->connect()->prepare($sql);
        $query->execute($params);
        $rs = $query->rowCount() or die(print_r($query->errorInfo(), true));
        self::__destruct();
        return $rs;
    }

    public function all($table){
      $sql = "select * from ".$table;
      $parametros = null;
      return $this->selectDB($sql,$parametros,$table);
    }
}
?>
