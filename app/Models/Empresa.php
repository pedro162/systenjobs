<?php
namespace App\Models;

use App\Models\BaseModel;
use \Exception;
use \InvalidArgumentException;

class Empresa extends BaseModel
{
    const TABLENAME = 'Empresa';

	private  $idEmpresa;
	private  $nome;
	private  $cnpj;
	private  $ie;
	private  $cidade;
	private  $estado;
	private  $bairro;
	private  $endereco;
	private  $complemento;
    private  $logo;



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

     public function getIdEmpresa()
    {
        if((! isset($this->data['idEmpresa'])) || ($this->data['idEmpresa'] <= 0)){

            if(isset($this->idEmpresa) && ($this->idEmpresa > 0)){
                return $this->idEmpresa;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['idEmpresa'];

    }

    public function getNome()
    {
        if((! isset($this->data['nome'])) || (strlen($this->data['nome']) == 0)){

            if(isset($this->nome) && (strlen($this->nome) > 0)){
                return $this->nome;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['nome'];

    }

    public function getCnpj()
    {
        if((! isset($this->data['cnpj'])) || (strlen($this->data['cnpj']) == 0)){

            if(isset($this->cnpj) && (strlen($this->cnpj) > 0)){
                return $this->cnpj;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['cnpj'];

    }

    public function getIe()
    {
        if((! isset($this->data['ie'])) || (strlen($this->data['ie']) == 0)){

            if(isset($this->ie) && ($this->ie > 0)){
                return $this->ie;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['ie'];

    }

    public function getLogo()
    {
        if((! isset($this->data['logo'])) || (strlen($this->data['logo']) == 0)){

            if(isset($this->logo) && (strlen($this->logo) > 0)){
                return $this->logo;
            }

            throw new Exception("Propriedade não definida\n");
            
        }

        return $this->data['logo'];

    }

}
