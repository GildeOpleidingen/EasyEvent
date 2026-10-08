<?php

session_start();

define('__ROOT__',  __DIR__ ."/");

require './vendor/autoload.php';

$router = require './src/Routes/index.php';