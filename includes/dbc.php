<?php

$user = 'root';
$senha = '';
$porta = 3306;
$dbname = 'osmakers';
$host = 'localhost';

$dsn = "mysql:host=$host:$porta;dbname=$dbname;charset=utf8mb4";
$dbc = new PDO($dsn, $user, $senha);
