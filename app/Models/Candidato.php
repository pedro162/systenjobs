<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Chate;
use App\Models\ConversaChate;
use \Exception;
use \InvalidArgumentException;

class Candidato extends BaseModel
{
	private $data = [];
    const TABLENAME = 'Candidato';
    
    private $idCandidato;
    private $nome;
    private $sobrenome;
    private $cpf;
    private $sexo;
    private $rg;
    private $img;
    private $dtNascimento;
    private $dtRegistro;
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

        return $this->insert($result);
        
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

// -------------------- SETTERS E GETTERS ----------------------------------

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

    public function setIdUsuario(Int $id)
    {
        if((! isset($id)) || ($id <= 0)){

            $this->setErrors("Parametro inválido\n");
            return false;
        }

        $this->data['idUsuario'] = $id;

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

    public function setNome(String $nome)
    {
        if((! isset($nome)) || (strlen(trim($nome))  == 0)){

            $this->setErrors("Nome inválido\n");
            return false;
        }

        $this->data['nome'] = $nome;

        return true;

    }


    public function getSobrenome()
    {
        if((! isset($this->data['sobrenome'])) || (strlen($this->data['sobrenome'] == 0))){
            if(isset($this->sobrenome) && (strlen($this->sobrenome) > 0)){
                return $this->sobrenome;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['sobrenome'];
    }


    public function setSobrenome(String $sobrenome)
    {
        if((! isset($sobrenome)) || (strlen(trim($sobrenome))  == 0)){

            $this->setErrors("Sobrenome inválido\n");
            return false;
        }

        $this->data['sobrenome'] = $sobrenome;

        return true;

    }

    public function getCpf()
    {
        if((! isset($this->data['cpf'])) || (strlen($this->data['cpf'] == 0))){
            if(isset($this->cpf) && (strlen($this->cpf) > 0)){
                return $this->cpf;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['cpf'];

    }

    public function setCpf(String $cpf)
    {
        if((! isset($cpf)) || (strlen(trim($cpf))  == 0)){

            $this->setErrors("CPF inválido\n");
            return false;
        }

        $this->data['cpf'] = $cpf;

        return true;

    }


    public function getRg()
    {
        if((! isset($this->data['rg'])) || (strlen($this->data['rg'] == 0))){
            if(isset($this->rg) && (strlen($this->rg) > 0)){
                return $this->rg;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['rg'];

    }

    public function setRg(String $rg)
    {
        if((! isset($rg)) || (strlen(trim($rg))  == 0)){

            $this->setErrors("RG inválido\n");
            return false;
        }

        $this->data['rg'] = $rg;

        return true;

    }


    public function getImg()
    {
        if((! isset($this->data['img'])) || (strlen($this->data['img'] == 0))){
            if(isset($this->img) && (strlen($this->img) > 0)){
                return $this->img;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['img'];

    }

    public function setImg(String $img)
    {
        if((! isset($img)) || (strlen(trim($img))  == 0)){

            $this->setErrors("Imagem inválida\n");
            return false;
        }

        $this->data['img'] = $img;

        return true;

    }


    public function getDtNascimento()
    {
        if((! isset($this->data['dtNascimento'])) || (strlen($this->data['dtNascimento'] == 0))){

            if(isset($this->dtNascimento) && (strlen($this->dtNascimento) > 0)){
                return $this->dtNascimento;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['dtNascimento'];

    }

    public function setDtNascimento(String $dtNascimento)
    {
        if((! isset($dtNascimento)) || (strlen(trim($dtNascimento))  == 0)){

            $this->setErrors("Data de nascimento inválida\n");
            return false;
        }

        $this->data['dtNascimento'] = $dtNascimento;

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


    public function setSexo(String $sexo)
    {
        if((! isset($sexo)) || (strlen(trim($sexo))  == 0)){

            $this->setErrors("Sexo  inválido\n");
            return false;
        }

        if(($sexo != 'm') || ($sexo != 'f')){

            $this->setErrors("Sexo  inválido\n");
            return false;
        }

        $this->data['sexo'] = $sexo;

        return true;

    }

    public function getSexo()
    {
         if((! isset($this->data['sexo'])) || (strlen($this->data['sexo'] == 0))){

            if(isset($this->sexo) && (strlen($this->sexo) > 0)){
                return $this->sexo;
            }

            throw new Exception("Propriedade não definida\n");
        }

        return $this->data['sexo'];

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
