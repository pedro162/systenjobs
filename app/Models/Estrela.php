<?php

namespace App\Models;

use App\Models\BaseModel;
use \Exception;
use \InvalidArgumentException;

class Estrela extends BaseModel
{
    private $data = [];
    
    const TABLENAME = 'Estrela';
    
	private $idEstrela;
	private $dtEstrela;
	private $numEstrela;
    private $UsuarioIdUsuario;

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
            return true;
        }

        throw new Exception("Falha ao registra o voto");
        
    }

    public function modify()
    {
        
    }

    public function findForId(Int $id)
    {
      

    }

    

}
