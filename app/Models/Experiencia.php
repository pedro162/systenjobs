<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Chate;
use App\Models\ConversaChate;
use \Exception;
use \InvalidArgumentException;

class Experiencia extends BaseModel
{
	private $data = [];
    const TABLENAME = 'Experiencia';

    private $idExperiencia;
	private $descricao;
	private $nomeEmpresa;
    private $cargo;
	private $dtInicio;
	private $dtFim;
	private $atual;
	private $idCandidato;
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

        return $this->insert($result);
        
    }

    public function modify()
    {
        $result = $this->parseCommit();

        return $this->update($result, $this->idExperiencia);
    }

    public function findForId(Int $id)
    {
        $result = $this->select(
                ['*'], [
                    ['key'=>'idExperiencia', 'val' => $id, 'comparator'=>'=']
                ]
            );

        return $result;

    }

// -------------------- SETTERS E GETTERS ----------------------------------

    public function getIdExperiencia()
    {
        if((! isset($this->data['idExperiencia'])) || ($this->data['idExperiencia'] <= 0)){

            if(isset($this->idExperiencia) && ($this->idExperiencia > 0)){
                return $this->idExperiencia;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['idExperiencia'];

    }

    public function setIdExperiencia(Int $id)
    {
        if((! isset($id)) || ($id <= 0)){

            $this->setErrors("Parametro inválido\n");
            return false;
        }

        $this->data['idExperiencia'] = $id;

        return true;

    }

    public function getDescricao()
    {
        if((! isset($this->data['descricao'])) || (strlen($this->data['descricao'] == 0))){
            if(isset($this->descricao) && (strlen($this->descricao) > 0)){
                return $this->descricao;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['descricao'];
    }

    public function setDescricao(String $descricao)
    {
        if((! isset($descricao)) || (strlen(trim($descricao))  == 0)){

            $this->setErrors("Descricao inválido\n");
            return false;
        }

        $this->data['descricao'] = $descricao;

        return true;

    }


    public function getCargo()
    {
        if((! isset($this->data['cargo'])) || (strlen($this->data['cargo'] == 0))){
            if(isset($this->cargo) && (strlen($this->cargo) > 0)){
                return $this->cargo;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['cargo'];
    }


    public function setCargo(String $cargo)
    {
        if((! isset($cargo)) || (strlen(trim($cargo))  == 0)){

            $this->setErrors("Cargo inválido\n");
            return false;
        }

        $this->data['cargo'] = $cargo;

        return true;

    }

    public function getAtual()
    {
        if((! isset($this->data['atual'])) || (strlen($this->data['atual'] == 0))){
            if(isset($this->atual) && (strlen($this->atual) > 0)){
                return $this->atual;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['atual'];

    }

    public function setAtual(String $atual)
    {
        if((! isset($atual)) || (strlen(trim($atual))  == 0)){

            $this->setErrors("Opão para empresa tual inválida\n");
            return false;
        }

        $this->data['atual'] = $atual;

        return true;

    }


    public function getIdCandidato()
    {
        if((! isset($this->data['idCandidato'])) || ($this->data['idCandidato'] <= 0)){
            if(isset($this->idCandidato) && ($this->data['idCandidato'] > 0)){
                return $this->idCandidato;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['idCandidato'];

    }

    public function setIdCandidato(Int $id)
    {
        if((! isset($id)) || ($id  <= 0)){

            $this->setErrors("Candidato inválido\n");
            return false;
        }

        $this->data['idCandidato'] = $id;

        return true;

    }



    public function getDtInicio()
    {
        if((! isset($this->data['dtInicio'])) || (strlen($this->data['dtInicio'] == 0))){

            if(isset($this->dtInicio) && (strlen($this->dtInicio) > 0)){
                return $this->dtInicio;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['dtInicio'];

    }

    public function setDtInicio(String $dtInicio)
    {
        if((! isset($dtInicio)) || (strlen(trim($dtInicio))  == 0)){

            $this->setErrors("Data de início inválida\n");
            return false;
        }

        $this->data['dtInicio'] = $dtInicio;

        return true;

    }

    public function getDtFim()
    {
        if((! isset($this->data['dtFim'])) || (strlen($this->data['dtFim'] == 0))){

            if(isset($this->dtFim) && (strlen($this->dtFim) > 0)){
                return $this->dtFim;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['dtFim'];

    }

    public function setDtFim(String $dtFim)
    {
        if((! isset($dtFim)) || (strlen(trim($dtFim))  == 0)){

            $this->setErrors("Data de fim inválida\n");
            return false;
        }

        $this->data['dtFim'] = $dtFim;

        return true;

    }


    public function setDtRegistro(String $dtRegistro)
    {
        if((! isset($dtRegistro)) || (strlen(trim($dtRegistro))  == 0)){

            $this->setErrors("Parãmetro inválido\n");
            return false;
        }

        $this->data['dtRegistro'] = $dtRegistro;

        return true;

    }

    public function getDtRegistro()
    {
         if((! isset($this->data['dtRegistro'])) || (strlen($this->data['dtRegistro'] == 0))){

            if(isset($this->dtRegistro) && (strlen($this->dtRegistro) > 0)){
                return $this->dtRegistro;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['dtRegistro'];

    }


    public function setNomeEmpresa(String $nomeEmpresa)
    {
        if((! isset($nomeEmpresa)) || (strlen(trim($nomeEmpresa))  == 0)){

            $this->setErrors("Empresa inválida\n");
            return false;
        }

        $this->data['nomeEmpresa'] = $nomeEmpresa;

        return true;

    }

    public function getNomeEmpresa()
    {
        if((! isset($this->data['nomeEmpresa'])) || (strlen($this->data['nomeEmpresa'] == 0))){

            if(isset($this->nomeEmpresa) && (strlen($this->nomeEmpresa) > 0)){
                return $this->nomeEmpresa;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['nomeEmpresa'];

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
