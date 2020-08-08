<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Chate;
use App\Models\ConversaChate;
use \Exception;
use \InvalidArgumentException;

class Admin extends BaseModel
{
	private $data = [];
    const TABLENAME = 'Admin';
    
	private $nome;
	private $idPessoa;
    private $idUsuario;

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
        $result = $this->parseCommit();

        $resultInsert = $this->insert($result);
        if($resultInsert == true){
            return ['msg','success','Categoria cadastrada com sucesso!'];
        }

        return ['msg','warning','Falha ao cadastrar categoria!'];
    }

    public function modify()
    {

    }

    public function findForId(Int $id)
    {
        $result = $this->select(
                ['*'], [
                    ['key'=>'idAdmin', 'val' => $id, 'comparator'=>'=', 'operator'=>'and']
                ]
            );

        return $result;

    }

    public function getIdUsuario()
    {
        if((! isset($this->data['idUsuario'])) || ($this->data['idUsuario'] <= 0)){

            if(isset($this->idUsuario) && ($this->idUsuario > 0)){
                return $this->idUsuario;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['idUsuario'];

    }

    public function getNome()
    {
        if((! isset($this->data['nome'])) || (strlen($this->data['nome'] == 0))){
            if(isset($this->nome) && (strlen($this->nome) > 0)){
                return $this->nome;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['nome'];
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
