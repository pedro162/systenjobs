<?php

namespace App\Models;

use App\Models\BaseModel;
use \Exception;
use \InvalidArgumentException;

class Vaga extends BaseModel
{
    const TABLENAME = 'Vaga';

	private  $idVaga;
	private  $descricao;
	private  $idNivel;
	private  $experiencia;
	private  $validadeVaga;
	private  $dataCriacao;
	private  $ativiadeDiaria;
	private  $salario;
	private  $idContrato;
	private  $idEmpresa;
	private  $idCargo;



    private $data = [];

    protected function parseCommit():array
    {
        return $this->data;
    }


    public function save()
    {

        $result = $this->parseCommit();

        $this->insert($result);
    }

    public function modify()
    {
        
    }

    public function findForId(Int $id)
    {
      

    }

    public function getIdVaga()
    {
        if((! isset($this->data['idVaga'])) || ($this->data['idVaga'] <= 0)){

            if(isset($this->idVaga) && ($this->idVaga > 0)){
                return $this->idVaga;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['idVaga'];

    }

    public function getDescricao()
    {
        if((! isset($this->data['descricao'])) || (strlen($this->data['descricao']) == 0)){

            if(isset($this->descricao) && (strlen($this->descricao) > 0)){
                return $this->descricao;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['descricao'];

    }

    public function getIdNivel()
    {
        if((! isset($this->data['idNivel'])) || ($this->data['idNivel'] <= 0)){

            if(isset($this->idNivel) && (strlen($this->idNivel) > 0)){
                return $this->idNivel;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['login'];

    }

    public function getExperiencia()
    {
        if((! isset($this->data['experiencia'])) || (strlen($this->data['experiencia']) == 0)){

            if(isset($this->experiencia) && (strlen($this->experiencia) > 0)){
                return $this->experiencia;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['experiencia'];

    }

    public function getValidadeVaga()
    {
        if((! isset($this->data['validadeVaga'])) || (strlen($this->data['validadeVaga']) == 0)){

            if(isset($this->validadeVaga) && (strlen($this->validadeVaga) > 0)){
                return $this->validadeVaga;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['validadeVaga'];

    }

    public function getDataCriacao()
    {
        if((! isset($this->data['dataCriacao'])) || (strlen($this->data['dataCriacao']) == 0)){

            if(isset($this->dataCriacao) && (strlen($this->dataCriacao) > 0)){
                return $this->dataCriacao;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['dataCriacao'];

    }

    public function getAtiviadeDiaria()
    {
        if((! isset($this->data['ativiadeDiaria'])) || (strlen($this->data['ativiadeDiaria']) == 0)){

            if(isset($this->ativiadeDiaria) && (strlen($this->ativiadeDiaria) > 0)){
                return $this->ativiadeDiaria;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['ativiadeDiaria'];

    }

    public function getSalario()
    {
        if((! isset($this->data['salario'])) || (strlen($this->data['salario']) == 0)){

            if(isset($this->salario) && (strlen($this->salario) > 0)){
                return $this->salario;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['salario'];

    }

    public function getIdContrato()
    {
        if((! isset($this->data['idContrato'])) || ($this->data['idContrato'] <= 0)){

            if(isset($this->idContrato) && (strlen($this->idContrato) > 0)){
                return $this->idContrato;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['idContrato'];

    }

    public function getIdEmpresa()
    {
        if((! isset($this->data['idEmpresa'])) || ($this->data['idEmpresa'] <= 0)){

            if(isset($this->idEmpresa) && (strlen($this->idEmpresa) > 0)){
                return $this->idEmpresa;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['idEmpresa'];

    }

    public function getIdCargo()
    {
        if((! isset($this->data['idCargo'])) || (strlen($this->data['idCargo']) == 0)){

            if(isset($this->idCargo) && (strlen($this->idCargo) > 0)){
                return $this->idCargo;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['idCargo'];

    }


    /*---------------------------------------- SETTHERS -----------------------*/



    public function setIdVaga(Int $idVaga):bool
    {
        if((! isset($idVaga)) || ($idVaga == 0)){

            
            throw new Exception("Nível informado inválido\n");
            
        }

        $this->data['idVaga'] = $idVaga;

        return true;

    }



    public function setDescricao(String $descricao):bool
    {
        if((! isset($descricao)) || (strlen($descricao) == 0)){

            
            throw new Exception("Descrição finformada inválida\n");
            
        }

        $this->data['descricao'] = $descricao;

        return true;

    }



    public function setIdNivel(Int $idNivel):bool
    {
        if((! isset($idNivel)) || ($idNivel == 0)){

            
            throw new Exception("Nível informado inválido\n");
            
        }

        $this->data['idNivel'] = $idNivel;

        return true;

    }



    public function setExperiencia(String $experiencia):bool
    {
        if((! isset($experiencia)) || (strlen($experiencia) == 0)){

            
            throw new Exception("Expreiência informada inválida\n");
            
        }

        $this->data['experiencia'] = $experiencia;

        return true;

    }


	public function setValidadeVaga(String $validadeVaga):bool
    {
        if((! isset($validadeVaga)) || (strlen($validadeVaga) == 0)){

            
            throw new Exception("Validade da vaga inválida\n");
            
        }

        $this->data['validadeVaga'] = $validadeVaga;

        return true;

    }



    public function setDataCriacao(String $dataCriacao):bool
    {
        if((! isset($dataCriacao)) || (strlen($dataCriacao) == 0)){

            
            throw new Exception("Criação da vaga inválido\n");
            
        }

        $this->data['dataCriacao'] = $dataCriacao;

        return true;

    }



    public function setAtividadeDiaria(String $ativiadeDiaria):bool
    {
        if((! isset($ativiadeDiaria)) || (strlen($ativiadeDiaria) == 0)){

            
            throw new Exception("Ativade diaria  informada inválida\n");
            
        }

        $this->data['ativiadeDiaria'] = $ativiadeDiaria;

        return true;

    }



    public function setSalario(float $salario):bool
    {
        if((! isset($salario)) || ($salario <= 0)){

            
            throw new Exception("Salário informado inválida\n");
            
        }

        $this->data['salario'] = $salario;

        return true;

    }



    public function setIdContrato(Int $id):bool
    {
        if((! isset($id)) || ($id <= 0)){

            
            throw new Exception("Tipo de contrato inválido\n");
            
        }

        $this->data['idContrato'] = $id;

        return true;

    }


    public function setIdEmpresa(Int $id):bool
    {
        if((! isset($id)) || ($id <= 0)){

            
            throw new Exception("Empresa inválida\n");
            
        }

        $this->data['idEmpresa'] = $id;

        return true;

    }


    public function setIdCargo(Int $id):bool
    {
        if((! isset($id)) || ($id <= 0)){

            
            throw new Exception("Cargo inválido\n");
            
        }

        $this->data['idCargo'] = $id;

        return true;

    }

}
