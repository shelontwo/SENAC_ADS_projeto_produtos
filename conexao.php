<?php


$host = "localhost";
$db   = "alunos";
$user = "postgres";
$pass = "123123";
$port = "5432"; // porta padrão do PostgreSQL

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

   // echo "✅ Conectado ao PostgreSQL com sucesso!";
} catch (PDOException $e) {
   // echo "❌ Erro: " . $e->getMessage();
}



?>