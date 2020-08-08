<?php

namespace App\Models;

use App\Models\BaseModel;
use \Core\Database\Transaction;
use \Exception;
use \InvalidArgumentException;
use App\Models\Imagem;
use \App\Models\Usuario;

class ConversaChate extends BaseModel
{
    private $idChate;
    private $locutor;
    private $locutario;
    private $unread;
    private $modification;
    private $dataChat;

    protected $data = []; //armazena chaves e valores filtrados por setters  para pessistencia no banco

    const TABLENAME = 'ConversaChate';

    protected function parseCommit()
    {   
        $arrayPase = [];
        for ($i=0; !($i == count($this->columns())) ; $i++) { 
            $chave = $this->columns()[$i]->Field;
            if(array_key_exists($chave, $this->data)){
                $arrayPase[$chave] = $this->data[$chave];
            }
        }
        return $arrayPase;
    }

    public function save()
    {
        $result = $this->parseCommit(); //retorna os dados já filtrados 
        $result['dtConversa'] = date('Y-m-d H:i:s');//define a data da mensagem

        $resultInsert = $this->insert($result);

        if($resultInsert == false){
        	throw new Exception("Erro ao enviar esta mensagem\n");
        	
        }
        return true;
    }

    //ajustar method de update
    public function modify()
    {
        $result = $this->parseCommit();

        $resultUpdate = $this->update($result, $this->getIdProduto());

        
    }

    public function loadConversationForPersonId(Int $id)
    {

    	if($id <= 0){
            throw new Exception('Parãmetro inválido');
            
        }

    	$sql = 'select * from ConversaChate where sender = '.$id.' and reciever = 1';
    	$sql .= ' or reciever = '.$id.' and sender = 1';
        $result = $this->persolizaConsulta($sql, false);

        return $result;
    }


    public function setTextChat(String $str)
    {
    	if((!isset($str)) || (strlen(trim($str)) == 0)){
    		throw new Exception("Parâmetro inválido\n");
    	}

    	$this->data['textChat'] = trim($str);

    	return true;
    }

    public function setSender(Int $id)
    {
    	if($id <= 0){
    		throw new Exception("Parâmetro inválido\n");
    	}

    	$this->data['sender'] = $id;
    	return true;
    }

    public function setReciever(Int $id)
    {
    	if($id <= 0){
    		throw new Exception("Parâmetro inválido\n");
    	}

    	$this->data['reciever'] = $id;
    	return true;
    }

    public function findForId(Int $id)
    {
      

    }
    

    public function __get($prop)
    {
        if(method_exists($this, 'get'.ucfirst($prop))){

            return call_user_func([$this,'get'.ucfirst($prop)]);
        }
    }

    public function __set($prop, $value)
    {   
        if(method_exists($this, 'set'.ucfirst($prop))){ 
            return call_user_func([$this,'set'.ucfirst($prop)], $value);
        }
    }
    


}

