<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use \Core\Database\Transaction;
use App\Models\Candidato;
use App\Models\Experiencia;
use \App\Models\Usuario;
use \Core\Utilitarios\Utils;
use Core\Utilitarios\Sessoes;
use \Exception;
use \PDOException;

class ExperienciaController extends BaseController
{
    
	public function index($request)
    {
    	try {
            
            //busca o usuario logado
            $usuario = Sessoes::usuarioLoad();
            if($usuario == false){
                header('Location:/usuario/index');
                
            }

            Transaction::startTransaction('connection');

            

            $this->setMenu('_candidato/candidatoMenu');
            $this->setFooter('_candidato/candidatoFooter');

            $registro = $usuario[0]->titular();

            $this->view->registro = $registro;
            $this->view->registros = $registro[0]->getExperiencia();
            $this->render('candidato/experiencia/index', true, 'layoutAdmin');

            Sessoes::clearMessage();
            
            Transaction::close();

        } catch (\PDOException $e) {
            
            Transaction::rollback();

        }catch (Exception $e){

            Transaction::rollback();

            $error = ['msg', 'warning','<strong>Atenção: </strong>'.$e->getMessage()];

            $this->view->result = json_encode($error);
            $this->render('candidato/ajax', false);
            Sessoes::sendMessage($error);
        }	
    }

    public function editar($request)
    {
        try {

            $usuario = Sessoes::usuarioLoad();
            if($usuario == false){
                header('Location:/usuario/index');
            }

            Transaction::startTransaction('connection');

            if((! isset($request['get']['experiencia'])) || ((int)$request['get']['experiencia']<= 0)){
                throw new Exception("Curso inválido\n");

            }

            $this->setMenu('_candidato/candidatoMenu');
            $this->setFooter('_candidato/candidatoFooter');

            $registro = $usuario[0]->titular();

            $this->view->registro = $registro;

            $experiencia = new Experiencia();

            $id = (int) $request['get']['experiencia'];

            $dados = $experiencia->select(['*'],

            [
                ['key'=>'idExperiencia', 'val'=> $id, 'comparator'=>'=', 'operator'=>'and'],
                ['key'=>'idCandidato', 'val'=> $registro[0]->getIdCandidato(), 'comparator'=>'=']
            ], null, 1, null, true, false);

            if($dados == false){

                throw new Exception("Curso inválido\n");
                
            }
            $this->view->dados = $dados;
            $this->render('candidato/experiencia/editar', true, 'layoutAdmin');

            Sessoes::clearMessage();
            
            Transaction::close();

        }catch (Exception $e){

            Transaction::rollback();

            $error = ['msg', 'warning','<strong>Atenção: </strong>'.$e->getMessage()];

            $this->view->result = json_encode($error);
            $this->render('candidato/ajax', false);
            Sessoes::sendMessage($error);
        }
    }

    public function atualizar($request)
    {
        try {

            $usuario = Sessoes::usuarioLoad();
            if($usuario == false){
                header('Location:/usuario/index');
            }

            Transaction::startTransaction('connection');

            if((! isset($request['post'])) || ( count($request['post']) == 0)){
                throw new Exception("Requisição inválida\n");

            }

            $registro = $usuario[0]->titular();

            $this->view->registro = $registro;

            $experiencia = new Experiencia();

            $id = (int) $request['post']['experiencia'];

            $dados = $experiencia->select(['*'],

            [
                ['key'=>'idExperiencia', 'val'=> $id, 'comparator'=>'=', 'operator'=>'and'],
                ['key'=>'idCandidato', 'val'=> $registro[0]->getIdCandidato(), 'comparator'=>'=']
            ], null, 1, null, true, false);

            if($dados == false){

                throw new Exception("Curso inválido\n");
                
            }

            $dados[0]->setDescricao($request['post']['desc_cargo'] ?? '');
            $dados[0]->setCargo($request['post']['cargo'] ?? '');
            $dados[0]->setAtual($request['post']['atual'] ?? '');
            $dados[0]->setDtInicio($request['post']['inicio'] ?? '');
            $dados[0]->setDtFim($request['post']['fim'] ?? '');
            $dados[0]->setNomeEmpresa($request['post']['empresa'] ?? '');

            $errors = $dados[0]->getErrors(); 

            if(strlen($errors) > 0){
                throw new Exception($errors);
                
            }

            $result = $dados[0]->modify();

            if($result == false){

                throw new Exception("Nenhuma informação foi atualizada\n");
                
            }

            Transaction::close();

            $success = ['msg', 'success','Registro atualizado com sucesso!'];

            Sessoes::sendMessage($success);
            header('Location: /experiencia/index');

        } catch (\PDOException $e) {
            
            Transaction::rollback();

            echo $e->getMessage();

        }catch (Exception $e){

            Transaction::rollback();

            $error = ['msg', 'warning','<strong>Atenção: </strong>'.$e->getMessage()];

            Sessoes::sendMessage($error);

            header('Location:/experiencia/editar?experiencia='.$id);
        }
    }

    public function salvar($request)
    {

        try {
            
            //busca o usuario logado
            $usuario = Sessoes::usuarioLoad();
            if($usuario == false){
                header('Location:/usuario/index');
                
            }

            Transaction::startTransaction('connection');

            if((! isset($request['post'])) || (count($request['post']) == 0)){
                throw new Exception('Requisição inválida');
            }

            $dados = $request['post'];

            /**
             * Armazena o formulario na sessao
             */
            Sessoes::storangeForm($dados);

            $experiencia = new Experiencia();

            $experiencia->setDescricao($dados['desc_cargo'] ?? '');
            $experiencia->setCargo($dados['cargo'] ?? '');
            $experiencia->setAtual($dados['atual'] ?? '');
            $experiencia->setIdCandidato($usuario[0]->titular()[0]->getIdCandidato());
            $experiencia->setDtInicio($dados['inicio'] ?? '');
            $experiencia->setDtFim($dados['fim'] ?? '');
            $experiencia->setNomeEmpresa($dados['empresa'] ?? '');
            $experiencia->setDtRegistro(date('Y-m-d H:i:s'));








            /**
             * Verifica se os dados informados pelo usuario sao válidos
             */
            $errosExperiencia = $experiencia->getErrors();

            if(strlen($errosExperiencia) > 0){

                throw new Exception($errosExperiencia.'<br/>');
            }



            $result = $experiencia->save();

            if($result == false){
                throw new Exception("Erro ao salvar registros");
                
            }

            /**
             * Limpa os dados do fromulario da sessao
             */
            Sessoes::clearForm();

            /**
             * Exibe uma mensagem de sucesso
             */
            Sessoes::sendMessage(['msg', 'success', 'Dados cadastrados com sucesso!']);

            /**
             * Redireciona o candidato para o proximo formulario
             */
            header('Location:/experiencia/index');

            Transaction::close();

        } catch (\PDOException $e) {
            
            Transaction::rollback();

        }catch (Exception $e){

            Transaction::rollback();

            $error = ['msg', 'warning','<strong>Atenção: </strong>'.$e->getMessage()];
            Sessoes::sendMessage($error);

            header('Location:/experiencia/adicionar');
        }
    }

    public function adicionar()
    {
        try {

            //busca o usuario logado
            $usuario = Sessoes::usuarioLoad();
            if($usuario == false){
                header('Location:/usuario/index');
                
            }

            Transaction::startTransaction('connection');
            
            $this->setMenu('_candidato/candidatoMenu');
            $this->setFooter('_candidato/candidatoFooter');

            $registro = $usuario[0]->titular();

            $this->view->registro = $registro;
            
            $this->render('candidato/experiencia/adicionar', true);
            
            Transaction::close();
            
            Sessoes::clearMessage();

        } catch (\PDOException $e) {
            
            Transaction::rollback();

        }catch (Exception $e){

            Transaction::rollback();

            $error = ['msg', 'warning','<strong>Atenção: </strong>'.$e->getMessage()];

            Sessoes::sendMessage($error);
        }
    }

    



}