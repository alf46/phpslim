<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require 'vendor/autoload.php';
require 'src/helper.php';
require 'src/config/db.php';

$app = new \Slim\App;

// Ruta usuarios.
require 'src/rutas/usuarios.php';
require 'src/rutas/transaction.php';

$app->run();