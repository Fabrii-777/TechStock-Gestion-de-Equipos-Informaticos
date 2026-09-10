<?php
// Configuración de la base de datos SUPABASE (PostgreSQL)
// Reemplaza estos datos con los de tu proyecto en Supabase

$host = "aws-0-us-east-1.pooler.supabase.com"; 
$port = "6543"; 
$dbname = "postgres"; 
$user = "postgres.tu_referencia_de_proyecto"; 
$password = "TuContrasenaSuperSegura123"; 

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $conexion = new PDO($dsn, $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a Supabase: " . $e->getMessage());
}
?>

