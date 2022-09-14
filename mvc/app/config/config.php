<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//todos os erros deixar só a linha abaixo
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// DB Params
// Quando estiver trabalhando com container do docker-compose
// DB_HOST é o nome do container que está rodando o banco de dados
define('DB_HOST', 'mysql');
define('DB_USER', 'root');
define('DB_PASS', 'rootadm');
define('DB_NAME', 'cmsdb');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// valor que está nesta constante /var/www/html/mvc/app

// URL ROOT PARA LINKS
define('URLROOT', 'http://' . $_SERVER["SERVER_NAME"] . '/mvc');

// Site Name
define('SITENAME', 'SharePosts');

//APP VERSION
define('APPVERSION', '1.0.0');

//CONSTANTE DE SESSAO PARA EVITAR QUE SISTEMAS DIFERENTES FIQUEM LOGADOS COM A MESMA SESSÃO
define('SE','mysis');

//RECUPERAÇÃO DE SENHA arquivo models\Users.php sendemail
define('APPEMAIL', 'sisurpe@educapenha.com.br');
define('EMAILPASSWORD', 'penha@sis');