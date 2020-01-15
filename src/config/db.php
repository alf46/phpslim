<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
 
class db{

    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPass = 'alfonso';
    private $dbName = 'alf_demo_db';

    //conección 
    public function conectDB()
    {
      $dbConnecion = new PDO(
        "mysql:host=$this->dbHost;dbname=$this->dbName", 
        $this->dbUser, 
        $this->dbPass, 
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
      );

      $dbConnecion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbConnecion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

      return $dbConnecion;
    }

    public function updateEntity($tableName, $array, $request, $id = 'id')
    { 
      $idval = $request->getAttribute($id);
      $params = array(":$id" => $idval);
      $sqlParams = [];
      
      foreach ($array as $param){
          $paramval = $request->getParam($param);
          if($paramval != null){
              $sqlParams[] = "$param = :$param";
              $params[":$param"] = $paramval;
          }
      }
      
      $sql = "UPDATE $tableName SET " . join(', ', $sqlParams) . " WHERE $id = :id";

      $connect = $this->conectDB();
      $resultado = $connect->prepare($sql);
      $resultado->execute($params);
    }
    public function addEntity($array, $request)
    { 
      $params = array();
      foreach ($array as $param)
      {
        $paramval = $request->getParam($param);
        $params[":".$param] = $paramval;
      }

      $sql = "INSERT INTO user(".join(",", $array).") VALUES(" . join(",",array_keys($params)) . ")";
      
      $connect = $this->conectDB();
      $resultado = $connect->prepare($sql);
      $resultado->execute($params);
    } 
  }
?>