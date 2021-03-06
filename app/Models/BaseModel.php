<?php

namespace App\Models;

use \Core\Database\Connection;
use \Core\Database\Transaction;
use Exception;
use InvalidArgumentException;
use \PDO;

abstract class BaseModel
{  

    protected $erros = [];

    protected static function getConn()
    {
        if(empty(self::$conn))
        {
            throw new Exception("Não existe conexão aberta<br/>");
        }
        return self::$conn;
    }

    protected function getTable()
    {
        return constant(get_class($this).'::TABLENAME');

    }

    public function countItens(Array $where = null):int
    {
        
        $sql = "SELECT COUNT(id{$this->getTable()}) totItens FROM {$this->getTable()}";

        if((isset($where)) && (count($where) > 0)){
            
            $sql .= ' WHERE';

            for ($i=0; !($i == count($where)); $i++) { 
                if(is_array($where[$i]) && (count($where[$i]) > 0)){
                    if(isset($where[$i]['key']) && isset($where[$i]['val']) && isset($where[$i]['comparator'])){

                        $key        = trim($where[$i]['key']);
                        $val        = trim($where[$i]['val']);
                        $comparator   = trim($where[$i]['comparator']);

                        if(!is_numeric($val)){
                            $val = $this->satinizar($val);
                        }

                        $sql .= ' '.$key.' '.$comparator.' '.$val;

                        if(isset($where[$i]['operator'])){
                            $sql .= ' '.$operator   = trim($where[$i]['operator']);
                        }
                    }
                }
            }
            
        }

        $conn = Transaction::get();

        $consulta = $conn->query($sql);

        $result = $consulta->fetchAll();

        return $result[0]->totItens;
        
    }


    public function paginador(array $campos, Int $itensPorPagina, Int $paginas, $class =  null)
    {   

        $inicio = ($itensPorPagina * $paginas) - $itensPorPagina;


        //$result = $this->select($campos, [],'=','asc', $inicio, $itensPorPagina, $class);
        
        //return $result;
       
    }

    public function columns()
    {
        $sql = 'SHOW COLUMNS FROM '.$this->getTable();
        $conn = Transaction::get();

        $result = $conn->query($sql);
        
        return $result->fetchAll();
    }



    //ao informar o filtro, o operador tambem deve ser invormado
    public function select(array $elementos, array $where, Array $ordem = null, $litmitInit = null, $limitEnd = null, $std = null, $groupBy = false)
    {


        $sql = "SELECT ";
        foreach($elementos as $key => $value)
        {
                    $sql .= $value.', ';
        }

        $sql = substr($sql, 0, -2);

        $sql .= ' FROM '.$this->getTable();


        $whe = '';

        if((isset($where)) && (count($where) > 0)){

            for ($i=0; !($i == count($where)); $i++) { 
                if(is_array($where[$i]) && (count($where[$i]) > 0)){
                    if(isset($where[$i]['key']) && isset($where[$i]['val']) && isset($where[$i]['comparator'])){

                        $key        = trim($where[$i]['key']);
                        $val        = trim($where[$i]['val']);
                        $comparator   = trim($where[$i]['comparator']);

                        if(!is_numeric($val)){
                            $val = $this->satinizar($val);
                        }

                        $whe .= ' '.$key.' '.$comparator.' '.$val;

                        if(isset($where[$i]['operator'])){
                            $whe .= ' '.$operator   = trim($where[$i]['operator']);
                        }
                    }
                }
            }
            
        }


        if(strlen($whe) > 0)
        {
            $sql .= " where ".$whe;

            
        }

        if($groupBy == true){
            $sql .= ' GROUP BY nome'.ucfirst($this->getTable());
        }

        if(! is_null($ordem)){
            if(is_array($ordem) && (count($ordem) > 0)){

                $sql .= ' ORDER BY';

                for ($i=0; !($i == count($ordem)) ; $i++) { 
                    $sql.= ' '.$ordem[$i]['key'].' '.$ordem[$i]['order'].',';
                }

                $sql = substr($sql, 0, -1);
            }
        }

        if(!is_null($litmitInit)){

            $sql .= ' LIMIT '.$litmitInit;

            if(! is_null($limitEnd)){
                $sql .= ','. $limitEnd;
            }
        }

        
        $conn = Transaction::get();

        $result = $conn->query($sql);


        $arrayObj = null;

        if($std){
            $arrayObj = $result->fetchAll(PDO::FETCH_CLASS, get_class($this));
           

        }else{
            $arrayObj = $result->fetchAll();
           
        }

        if($arrayObj)
        {
            return $arrayObj;
        }

        return false;


    }


    public function delete(Array $where, Int $limit = null):bool
    {
        
        $sql = 'DELETE FROM '.$this->getTable();

        $whe = '';

        if((isset($where)) && (count($where) > 0)){

            for ($i=0; !($i == count($where)); $i++) { 
                if(is_array($where[$i]) && (count($where[$i]) > 0)){
                    if(isset($where[$i]['key']) && isset($where[$i]['val']) && isset($where[$i]['comparator'])){

                        $key        = trim($where[$i]['key']);
                        $val        = trim($where[$i]['val']);
                        $comparator   = trim($where[$i]['comparator']);

                        if(!is_numeric($val)){
                            $val = $this->satinizar($val);
                        }

                        $whe .= ' '.$key.' '.$comparator.' '.$val;

                        if(isset($where[$i]['operator'])){
                            $whe .= ' '.$operator   = trim($where[$i]['operator']);
                        }
                    }
                }
            }
            
        }


        if(strlen($whe) > 0)
        {
            $sql .= " where ".$whe;

            
        }

        if($limit != null){
            $sql .= ' limit '.$limit;
        }

        $conn = Transaction::get();

        $result = $conn->exec($sql);
        if($result > 0)
        {
            return true;
        }

        throw new Exception("Erro ao excluir registro<br/>\n");
        
    }


    public function insert(array $elementos):bool
    {
        $sql = "INSERT INTO {$this->getTable()} (";

        $keys = '';
        $values = '';

        foreach ($this->satinizar($elementos) as $key => $value)
        {
            $keys .= $key.', ';
            $values .= $value.', ';
        }


        $keys = substr($keys, 0, -2);
        $values  = substr($values, 0, -2);

        $sql .="{$keys}) VALUES ({$values})";

        $conn = Transaction::get();

        $result = $conn->exec($sql);
        //$result = self::$conn->query($sql);

        if($result > 0)
        {
            return true;
        }

        return false;


    }




    public function update(array $elementos, int $id, Int $limit = 1):bool
    {

        //return Commit::update($this->table, $elementos, $id);
        //update nome table set campo = valor and novocampo = novovalor
        $sql = "UPDATE {$this->getTable()} SET ";

        foreach ($this->satinizar($elementos) as $key => $value)
        {
           $sql .= $key.'='.$value.", ";
        }

        $sql = substr($sql, 0, -2);

        $sql .= " where id{$this->getTable()}={$id} limit {$limit}";

        $conn = Transaction::get();
        $result = $conn->exec($sql);

        if($result > 0)
        {
            return true;
        }
        return false;

    }


    protected function satinizar($elemento, $like =false)
    {
        if(empty($elemento) || (!isset($elemento)))
        {
            throw new Exception("Parametro inválido<br/>\n");
        }

        $newElemento = null;

        if(is_array($elemento))
        {
            if(count($elemento) == 0)
            {
                throw new Exception("Parametro inválido!<br/>\n");
            }

            $newElemento = [];
            foreach($elemento as $key => $value)
            {
                $key = trim($key);
                $key = htmlspecialchars($key);

                $value = trim($value);
                $value = htmlspecialchars($value);

                $conn = Transaction::get();

                $value = $conn->quote($value);

                if($like == true){
                    $value = strtr($value, ['_'=>'\_']);
                }else{
                    $value = strtr($value, ['_'=>'\_', '%'=> '\%']);
                }
                
                $newElemento[$key] = $value;

                
            }
        }
        else
        {
                $elemento = trim($elemento);
                $elemento = htmlspecialchars($elemento);

                $conn = Transaction::get();
                $elemento = $conn->quote($elemento);
                //$elemento = self::$conn->quote($elemento);
                if($like == true){
                    $elemento = strtr($elemento, ['_'=>'\_']);
                }else{
                    $elemento = strtr($elemento, ['_'=>'\_', '%'=> '\%']);
                }
                
                $newElemento = $elemento;
        }

        if($newElemento != null)
        {
            return $newElemento;
        }
        return false;
    }



    protected function persolizaConsulta(String $sql, $clasRetorno = false)
    {
        $conn = Transaction::get();
        $result = $conn->query($sql);

        if($clasRetorno != false){

             $arrayObj = $result->fetchAll(PDO::FETCH_CLASS,  get_class($this));

        }else{

            $arrayObj = $result->fetchAll();
        }



        if(count($arrayObj) == 0)
        {
            return false;
        }
        
        return $arrayObj;
    }


    /*protected function parseStdClass($obj)
    {
        $teste = new \ReflectionClass(get_class($this));
        $methods = $teste->getMethods();
        $propriedades = $teste->getProperties();

        $stdclass = new \stdclass();

        for ($i=0; !($i == count($methods)) ; $i++) { 
            if(substr($methods[$i], 0, 2) == 'get'){
                $stdclass->methods[$i];
            }
            
        }
        var_dump();
    }*/


    protected function parseRequestAjax(array $dados){
        $superArray = [];

        for ($i=0; !($i == count($dados)); $i++) { 
            $resultado = null;

            $chave = null;

            for ($j=0; !($j == count($dados[$i])); $j++) {

                $chave = $dados[$i][0];
                if($j != 0){
                    $resultado[] = $dados[$i][$j];
                }
                
            }

            $superArray[$chave] = $resultado;
            
        }

        return $superArray;
    }


    public function maxId():int
    {
        $id = 'id'.ucfirst($this->getTable());
        $sql = "SELECT MAX({$id}) as maxId from {$this->getTable()}";

        $conn = Transaction::get();

        $consulta = $conn->query($sql);

        $result = $consulta->fetchObject();
        if($result){
            return $result->maxId;
        }

    }


    public function minId():int
    {
        $id = 'id'.ucfirst($this->getTable());
        $sql = "SELECT min({$id}) as minId from {$this->getTable()}";

        $conn = Transaction::get();

        $consulta = $conn->query($sql);

        $result = $consulta->fetchObject();
        if($result){
            return $result->minId;
        }

    }


    //retorna os erros de valdiadão
    public function getErrors()
    {
        $warning = '';

        if(count($this->erros) > 0){
            for ($i=0; !($i == count($this->erros) ); $i++) { 
                $warning .= $this->erros[$i].' <br/>'.PHP_EOL;
            }

            $warning = substr($warning, 0, -5);
        }
        return $warning;
    }

    //adiciona os erros num array
    public function setErrors(String $erro)
    {   
        if(strlen(trim($erro)) == 0){
            throw new Exception("Parãmetro inválido");
            
        }
        
        $this->erros[] = trim($erro);

        return true;
    }


    abstract protected function parseCommit();

    abstract public function save();

    abstract public function modify();
    abstract public function findForId(Int $id);



}

