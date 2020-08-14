<?php
$routes = [];

$routes[] = ['/', 'SiteController@index'];

$routes[] = ['/categoria/index', 'CategoriaController@index'];
$routes[] = ['/chat/index', 'ChateController@index'];
$routes[] = ['/pagar/index', 'PagarController@index'];

$routes[] = ['/candidato/index', 'CandidatoController@index'];
$routes[] = ['/candidato/adicionar', 'CandidatoController@adicionar'];
$routes[] = ['/candidato/salvar', 'CandidatoController@salvar'];
$routes[] = ['/candidato/finalizar/curriculo', 'CandidatoController@finalizarCurriculo'];
$routes[] = ['/candidato/info', 'CandidatoController@info'];

$routes[] = ['/curso/index', 'CursoController@index'];
$routes[] = ['/curso/adicionar', 'CursoController@adicionar'];
$routes[] = ['/curso/editar', 'CursoController@editar'];
$routes[] = ['/curso/atualizar', 'CursoController@atualizar'];
$routes[] = ['/curso/salvar', 'CursoController@salvar'];

$routes[] = ['/experiencia/index', 'ExperienciaController@index'];
$routes[] = ['/experiencia/adicionar', 'ExperienciaController@adicionar'];
$routes[] = ['/experiencia/editar', 'ExperienciaController@editar'];
$routes[] = ['/experiencia/salvar', 'ExperienciaController@salvar'];
$routes[] = ['/experiencia/atualizar', 'ExperienciaController@atualizar'];

$routes[] = ['/admin/index', 'AdminController@index'];

$routes[] = ['/usuario/index', 'UserController@index'];
$routes[] = ['/usuario/logar', 'UserController@logar'];
$routes[] = ['/usuario/sair', 'UserController@logout'];
$routes[] = ['/usuario/adicionar', 'UserController@adicionar'];
$routes[] = ['/usuario/salvar', 'UserController@salvar'];

return $routes;