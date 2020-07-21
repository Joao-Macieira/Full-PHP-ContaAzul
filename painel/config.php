<?php

require "environment.php";

$config = array();

if(ENVIRONMENT == 'development'){
    define("BASE_URL", "http://projetoy.pc/painel/");
    $config['dbname'] = 'ead';
    $config['host']  = 'localhost';
    $config['dbuser']  = 'root';
    $config['dbpass'] = 'Mtech2020begin!';
} else {
    #Dados do banco de dados do servidor
    define("BASE_URL", "http://meusite.com.br/");
    $config['dbname'] = 'ead';
    $config['host']  = 'localhost';
    $config['dbuser']  = 'root';
    $config['dbpass'] = 'Mtech2020begin!';
}

global $pdo;

try {
    $pdo = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
} catch (PDOException $e){
    echo "ERROR: ".$e->getMessage();
    exit;
}
