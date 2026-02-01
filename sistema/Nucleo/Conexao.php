<?php

namespace sistema\Nucleo;

use PDO;
use PDOException;

class Conexao
{
    private static $instance;

    public static function getInstancia() :PDO
    {
        if(empty(self::$instance)){

            try {
                self::$instance = new PDO('mysql:host='.DB_HOST.';port='.DB_PORTA.';dbname='.DB_NOME, DB_USUARIO, DB_SENHA, [
                    # Garante que o charset do PDO seja o mesmo do banco de dados
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    # Todo erro através da PDO será uma exceção
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    # Converte qualquer resultado como um objeto anônimo 
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    # Garante que o mesmo nome das colunas do banco seja utilzado
                    PDO::ATTR_CASE => PDO::CASE_NATURAL
                ]);
            } catch (\PDOException $ex) {
                die("Erro de conexão:: ".$ex->getMessage());
            }
        }

        return self::$instance;
    }

    protected function __construct()
    {
        
    }

    private function __clone(): void
    {
        
    }
}