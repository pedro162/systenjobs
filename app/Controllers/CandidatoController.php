<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use \Core\Database\Transaction;
use App\Models\Candidato;
use \App\Models\Usuario;
use \Core\Utilitarios\Utils;
use Core\Utilitarios\Sessoes;
use \Exception;

class CandidatoController extends BaseController
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
            $this->render('candidato/index', true, 'layoutAdmin');
            
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

    public function salvar($request)
    {
        try {
            
            Transaction::startTransaction('connection');

            if((! isset($request['post'])) || (count($request['post']) == 0)){
                throw new Exception('Requisição inválida');
            }

            $dados = $request['post'];

            /**
             * Armazena os dados do formulario na sessao 
             * para previnir de possiveis erros
             */
            Sessoes::storangeForm($dados);

            $usuario = new Usuario();

            $usuario->setLogin($dados['email']);
            $usuario->setSenha($dados['senha']);
            $usuario->setTipoUsuario('candidato');
            $usuario->setDtRegistro(date('Y-m-d H:i:s'));
            
            $candidato = new Candidato();

            $candidato->setNome($dados['nome'] ?? '');
            $candidato->setSobrenome($dados['sobrenome'] ?? '');
            $candidato->setCpf($dados['cpf'] ?? '');
            //$candidato->setRg($dados['rg'] ?? '');
            //$candidato->setImg($dados['post'] ?? '');
            $candidato->setDtNascimento($dados['nascimento'] ?? '');
            $candidato->setDtRegistro(date('Y-m-d H:i:s'));
            $candidato->setSexo($dados['sexo'] ?? '');


            /*
            
            phone_1
            phone_2*/

            /**
             * Verifica se os dados informados pelo usuario sao válidos
             */
            $errosUsuario = $usuario->getErrors();
            $errosCandidato = $candidato->getErrors();

            if((strlen($errosUsuario) > 0) || (strlen($errosUsuario) > 0)){

                throw new Exception($errosUsuario.'<br/>'.$errosUsuario);
            }


            /**
             * Salva as informaçoes no banco, caso esteja tudo ok
             */

            $resultUser = $usuario->save();

            if($resultUser == false){
                throw new Exception("Erro ao salvar registros");
                
            }

            $lastIdUser = $usuario->maxId();

            /**
             * Define o usurio do candidato e salva no banco de dado
             */
            $candidato->setIdUsuario($lastIdUser);
            $resultCand = $candidato->save();

            if($resultCand == false){
                throw new Exception("Erro ao salvar registros");
                
            } 

            
            Transaction::close();

            /**
             * Limpa os dados do fromulario da sessao
             */
            Sessoes::clearForm();
            Sessoes::sendMessage(['msg', 'success', 'Dados cadastrados com sucesso!']);

            /**
             * Redireciona o candidato para o proximo formulario
             */
            header('Location:/curso/adicionar');


        } catch (\PDOException $e) {
            
            Transaction::rollback();

        }catch (Exception $e){

            Transaction::rollback();

            $error = ['msg', 'warning','<strong>Atenção: </strong>'.$e->getMessage()];
            Sessoes::sendMessage($error);

            /**
             * Redireciona o candidato de volta ao formulario
             */
            header('Location:/candidato/adicionar');

        }


    }

    public function editar($request)
    {

    }

    public function atualizar($request)
    {
        
    }

    public function adicionar()
    {
        try {

            Transaction::startTransaction('connection');

            $this->setMenu();
            $this->setFooter();
            
            $this->render('candidato/adicionar', true);

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

    public function curriculo($request)
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
            $this->render('candidato/curriculo/curriculo', true, 'layoutAdmin');
            
            Transaction::close();

        } catch (\PDOException $e) {
            
            Transaction::rollback();

        }catch (Exception $e) {

            Transaction::rollback();
            
            $error = ['msg', 'warning','<strong>Atenção: </strong>'.$e->getMessage()];

            Sessoes::sendMessage($error);
        }   
    }



}