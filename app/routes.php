<?php
$routes = [];

$routes[] = ['/', 'SiteController@index'];

$routes[] = ['/categoria/index', 'CategoriaController@index'];
$routes[] = ['/chat/index', 'ChateController@index'];
$routes[] = ['/pagar/index', 'PagarController@index'];

$routes[] = ['/candidato/index', 'CandidatoController@index'];
$routes[] = ['/candidato/curriculo', 'CandidatoController@curriculo'];
$routes[] = ['/candidato/adicionar', 'CandidatoController@adicionar'];
$routes[] = ['/candidato/salvar', 'CandidatoController@salvar'];

$routes[] = ['/curso/index', 'CursoController@index'];
$routes[] = ['/curso/curriculo', 'CursoController@curriculo'];
$routes[] = ['/curso/adicionar', 'CursoController@adicionar'];

$routes[] = ['/experiencia/index', 'ExperienciaController@index'];
$routes[] = ['/experiencia/curriculo', 'ExperienciaController@curriculo'];
$routes[] = ['/experiencia/adicionar', 'ExperienciaController@adicionar'];

$routes[] = ['/admin/index', 'AdminController@index'];

$routes[] = ['/usuario/index', 'UserController@index'];
$routes[] = ['/usuario/logar', 'UserController@logar'];
$routes[] = ['/usuario/sair', 'UserController@logout'];

return $routes;