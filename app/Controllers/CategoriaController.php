<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \Core\Database\Transaction;
use App\Models\Categoria;

class CategoriaController extends BaseController
{
    
    public function index($request)
    {
       Transaction::startTransaction('connection');

        Transaction::close();
    }

    
}