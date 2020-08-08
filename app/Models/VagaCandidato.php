idCandidatoVaga
dtCandidatura
idCandidato
idVaga
dtRegistro
<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Chate;
use App\Models\ConversaChate;
use \Exception;
use \InvalidArgumentException;

class VagaCandidato extends BaseModel
{
	private $data = [];
    const TABLENAME = 'VagaCandidato';
    
	private $idCandidatoVaga;
	private $dtCandidatura;
    private $idCandidato;
    private $idVaga;
    private $dtRegistro;

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
                ['idCandidato', 'nome'], [
                    ['key'=>'idCandidato', 'val' => 1, 'comparator'=>'=', 'operator'=>'and'],
                    ['key'=>'nome', 'val' => 'pedro', 'comparator'=>'=']
                ]
            );

        return $result;

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
