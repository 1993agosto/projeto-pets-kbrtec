<?php 
    class DbConnect {
        public $pdo;
        
        public static function realizarConexao(){
            return $pdo = new PDO("mysql:host=localhost;dbname=petsdb;chasert=utf-8", 'root', '');
        }
    }
?>