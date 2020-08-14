<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use \Core\Database\Transaction;
use App\Models\Candidato;
use \App\Models\Usuario;
use \App\Models\Curso;
use \Core\Utilitarios\Utils;
use Core\Utilitarios\Sessoes;
use \Exception;

class CursoController extends BaseController
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

            $this->view->registros = $registro[0]->getCurso();
        
            $this->render('candidato/curso/index', true, 'layoutAdmin');
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

            if((! isset($request['get']['curso'])) || ((int)$request['get']['curso']<= 0)){
                throw new Exception("Curso inválido\n");

            }

            $this->setMenu('_candidato/candidatoMenu');
            $this->setFooter('_candidato/candidatoFooter');

            $registro = $usuario[0]->titular();

            $this->view->registro = $registro;

            $curso = new Curso();

            $id = (int) $request['get']['curso'];

            $dados = $curso->select(['*'],

            [
                ['key'=>'idCurso', 'val'=> $id, 'comparator'=>'=', 'operator'=>'and'],
                ['key'=>'idCandidato', 'val'=> $registro[0]->getIdCandidato(), 'comparator'=>'=']
            ], null, 1, null, true, false);

            if($dados == false){

                throw new Exception("Curso inválido\n");
                
            }
            $this->view->dados = $dados;
            $this->render('candidato/curso/editar', true, 'layoutAdmin');

            Sessoes::clearMessage();
            
            Transaction::close();

        } catch (\PDOException $e) {
            
            Transaction::rollback();

        }catch (Exception $e){

            Transaction::rollback();

            $error = ['msg', 'warning','<strong>Atenção: </strong>'.$e->getMessage()];

            Sessoes::sendMessage($error);

            header('Location: /curso/adicionar');
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

            $curso = new Curso();

            $id = (int) $request['post']['curso'];

            $dados = $curso->select(['*'],

            [
                ['key'=>'idCurso', 'val'=> $id, 'comparator'=>'=', 'operator'=>'and'],
                ['key'=>'idCandidato', 'val'=> $registro[0]->getIdCandidato(), 'comparator'=>'=']
            ], null, 1, null, true, false);

            if($dados == false){

                throw new Exception("Curso inválido\n");
                
            }

            
            $dados[0]->setInstituicao($request['post']['instituicao'] ?? '');
            $dados[0]->setTipo($request['post']['tipo'] ?? '');
            $dados[0]->setStatus($request['post']['status'] ?? '');
            $dados[0]->setTurno($request['post']['turno']);
            $dados[0]->setModalidade($request['post']['modalidade'] ?? '');
            $dados[0]->setNome($request['post']['nome'] ?? '');
            $dados[0]->setDtInicio($request['post']['inico'] ?? '');
            $dados[0]->setDtTermino($request['post']['termino'] ?? '');

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
            header('Location: /curso/adicionar');

        } catch (\PDOException $e) {
            
            Transaction::rollback();

        }catch (Exception $e){

            Transaction::rollback();

            $error = ['msg', 'warning','<strong>Atenção: </strong>'.$e->getMessage()];

            Sessoes::sendMessage($error);

            header('Location: /curso/editar');
        }
        
    }

    public function adicionar()
    {
        try {

            $usuario = Sessoes::usuarioLoad();
            if($usuario == false){
                header('Location:/usuario/index');
            }

            Transaction::startTransaction('connection');

            $this->setMenu('_candidato/candidatoMenu');
            $this->setFooter('_candidato/candidatoFooter');

            $registro = $usuario[0]->titular();

            $this->view->registro = $registro;

            $this->render('candidato/curso/adicionar', true, 'layoutAdmin');
        
            
            Sessoes::clearMessage();
            
            Transaction::close();

        } catch (\PDOException $e) {
            
            Transaction::rollback();

        }catch (Exception $e){

            Transaction::rollback();

            $error = ['msg', 'warning','<strong>Atenção: </strong>'.$e->getMessage()];

            Sessoes::sendMessage($error);
        }
    }


    public function salvar($request)
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

            Sessoes::storangeForm($request['post']);
            
            $registro = $usuario[0]->titular();

            $this->view->registro = $registro;

            $curso = new Curso();
            
            $curso->setInstituicao($request['post']['instituicao'] ?? '');
            $curso->setTipo($request['post']['tipo'] ?? '');
            $curso->setStatus($request['post']['status'] ?? '');
            $curso->setTurno($request['post']['turno']);
            $curso->setModalidade($request['post']['modalidade'] ?? '');
            $curso->setNome($request['post']['nome'] ?? '');
            $curso->setDtInicio($request['post']['inico'] ?? '');
            $curso->setDtTermino($request['post']['termino'] ?? '');
            $curso->setIdNivel(1); //ajusta para o vivel pego do banco
            $curso->setIdCandidato($registro[0]->getIdCandidato()); 

            $errors = $curso->getErrors(); 

            if(strlen($errors) > 0){
                throw new Exception($errors);
                
            }

            $result = $curso->save();

            if($result == false){

                throw new Exception("Erro ao salvar registro\n");
                
            }

            Transaction::close();

            $success = ['msg', 'success','Registro adicionado com sucesso!'];

            Sessoes::sendMessage($success);
            header('Location: /experiencia/adicionar');

        } catch (\PDOException $e) {
            
            Transaction::rollback();
            echo $e->getMessage();

        }catch (Exception $e){

            Transaction::rollback();

            $error = ['msg', 'warning','<strong>Atenção: </strong>'.$e->getMessage()];

            Sessoes::sendMessage($error);

            header('Location: /curso/editar');
        }
        
    }

    



}