<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Chate;
use App\Models\ConversaChate;
use \Exception;
use \InvalidArgumentException;

class Curso extends BaseModel
{
	private $data = [];
    const TABLENAME = 'Curso';

	private $idCurso;
	private $nome;
	private $instituicao;
	private $idNivel;
	private $status;
	private $tipo;
	private $dtInicio;
	private $dtTermino;
	private $turno;
	private $modalidade;
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

        return $this->update($result, $this->idCurso);

    }

    public function findForId(Int $id)
    {
        $result = $this->select(
                ['*'], [
                    ['key'=>'idCurso', 'val' => $id, 'comparator'=>'=']
                ]
            );

        return $result;

    }

// -------------------- SETTERS E GETTERS ----------------------------------

    public function getIdCurso()
    {
        if((! isset($this->data['idCurso'])) || ($this->data['idCurso'] <= 0)){

            if(isset($this->idCurso) && ($this->idCurso > 0)){
                return $this->idCurso;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['idCurso'];

    }

    public function setIdCursoInt ($id)
    {
        if((! isset($id)) || ($id <= 0)){

            $this->setErrors("Parametro inválido\n");
            return false;
        }

        $this->data['idCurso'] = $id;

        return true;

    }

    public function getInstituicao()
    {
        if((! isset($this->data['instituicao'])) || (strlen($this->data['instituicao'] == 0))){
            if(isset($this->instituicao) && (strlen($this->instituicao) > 0)){
                return $this->instituicao;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['instituicao'];
    }

    public function setInstituicao(String $instituicao)
    {
         if((! isset($instituicao)) || (strlen(trim($instituicao))  == 0)){

            $this->setErrors("Instituicao inválida\n");
            return false;
        }

        $this->data['instituicao'] = $instituicao;

        return true;
    }


    public function getTipo()
    {
        if((! isset($this->data['tipo'])) || (strlen($this->data['tipo'] == 0))){
            if(isset($this->tipo) && (strlen($this->tipo) > 0)){
                return $this->tipo;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['tipo'];
    }

    public function setTipo(String $tipo)
    {
         if((! isset($tipo)) || (strlen(trim($tipo))  == 0)){

            $this->setErrors("Tipo inválido\n");
            return false;
        }

        $sentinela = false;
        switch ($tipo) {
            case 'graduacao':
                $sentinela = true;
                break;
            case 'pos-graduacao':
                $sentinela = true;
                break;
            case 'especializacao':
                $sentinela = true;
                break;
            
            case 'profissionalizante':
                $sentinela = true;
                break;
        }

        if($sentinela == false){
            $this->setErrors("Tipo inválido\n");
            return false;
        }

        $this->data['tipo'] = $tipo;

        return true;
    }

    public function getStatus()
    {
        if((! isset($this->data['status'])) || (strlen($this->data['status'] == 0))){
            if(isset($this->status) && (strlen($this->status) > 0)){
                return $this->status;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['status'];
    }

    public function setStatus(String $status)
    {
        if((! isset($status)) || (strlen(trim($status))  == 0)){

            $this->setErrors("Status inválido\n");
            return false;
        }

        $sentinela = false;
        switch ($status) {
            case 'cursando':
                $sentinela = true;
                break;
            case 'trancado':
                $sentinela = true;
                break;
            case 'concluido':
                $sentinela = true;
                break;
        }

        if($sentinela == false){
            $this->setErrors("Status inválido\n");
            return false;
        }

        $this->data['status'] = $status;

        return true;
    }

    public function getTurno()
    {
        if((! isset($this->data['turno'])) || (strlen($this->data['turno'] == 0))){
            if(isset($this->turno) && (strlen($this->turno) > 0)){
                return $this->turno;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['turno'];
    }

    public function setTurno(String $turno)
    {
        if((! isset($turno)) || (strlen(trim($turno))  == 0)){

            $this->setErrors("turno inválido\n");
            return false;
        }

        $sentinela = false;
        switch ($turno) {
            case 'matutino':
                $sentinela = true;
                break;
            case 'vespertino':
                $sentinela = true;
                break;
            case 'noturno':
                $sentinela = true;
                break;
        }

        if($sentinela == false){

            $this->setErrors("Turno inválido\n");
            return false;
        }

        $this->data['turno'] = $turno;

        return true;
    }

    public function getModalidade()
    {
        if((! isset($this->data['modalidade'])) || (strlen($this->data['modalidade'] == 0))){
            if(isset($this->modalidade) && (strlen($this->modalidade) > 0)){
                return $this->modalidade;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['modalidade'];
    }

    public function setModalidade(String $modalidade)
    {
        if((! isset($modalidade)) || (strlen(trim($modalidade))  == 0)){

            $this->setErrors("Modalidade inválido\n");
            return false;
        }

        $sentinela = false;
        switch ($modalidade) {
            case 'presencial':
                $sentinela = true;
                break;
            case 'ead':
                $sentinela = true;
                break;
            case 'semepresencial':
                $sentinela = true;
                break;
        }

        if($sentinela == false){

            $this->setErrors("Modalidade inválida\n");
            return false;
        }

        $this->data['modalidade'] = $modalidade;

        return true;
    }

    public function setNome(String $nome)
    {
        if((! isset($nome)) || (strlen(trim($nome))  == 0)){

            $this->setErrors("Nome inválido\n");
            return false;
        }

        $this->data['nome'] = $nome;

        return true;

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


    public function getIdNivel()
    {
        if((! isset($this->data['idNivel'])) || ($this->data['idNivel'] <= 0)){
            if(isset($this->idNivel) && ($this->data['idNivel'] > 0)){
                return $this->idNivel;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['idNivel'];

    }

    public function setIdNivel(Int $id)
    {
        if((! isset($id)) || ($id  <= 0)){

            $this->setErrors("Nivel inválido\n");
            return false;
        }

        $this->data['idNivel'] = $id;

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

    public function getDtTermino()
    {
        if((! isset($this->data['dtTermino'])) || (strlen($this->data['dtTermino'] == 0))){

            if(isset($this->dtTermino) && (strlen($this->dtTermino) > 0)){
                return $this->dtTermino;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['dtTermino'];

    }

    public function setDtTermino(String $dtTermino)
    {
        if((! isset($dtTermino)) || (strlen(trim($dtTermino))  == 0)){

            $this->setErrors("Data de fim inválida\n");
            return false;
        }

        $this->data['dtTermino'] = $dtTermino;

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
