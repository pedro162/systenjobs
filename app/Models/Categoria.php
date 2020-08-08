<?php

namespace App\Models;

use App\Models\BaseModel;
use \Exception;
use \InvalidArgumentException;

class Categoria extends BaseModel
{
    private $data = [];
    
    const TABLENAME = 'Categoria';
    
	private $nomeCategoria;
	private $idCategoria;


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
      

    }


}
