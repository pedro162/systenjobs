<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use \Core\Database\Transaction;
use App\Models\Candidato;
use \App\Models\Usuario;
use \App\Models\ConversaChate;
use \App\Models\Chate;
use \Core\Utilitarios\Utils;
use Core\Utilitarios\Sessoes;
use \Exception;

class ChateController extends BaseController
{
    
    public function index()
    {
    	try {
           
    		Transaction::startTransaction('connection');

    		Transaction::close();
    		
    	} catch (\Exception $e) {
    		Transaction::rollback();

            $erro = ['msg','warning', $e->getMessage()];
    	}
    }
	
}