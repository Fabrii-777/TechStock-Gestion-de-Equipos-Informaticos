<?php
// Configuración de la base de datos SUPABASE (PostgreSQL)
// Reemplaza estos datos con los de tu proyecto en Supabase

$host = "db.zejwgocnnunpgbyooxbw.supabase.co"; 
$port = "5432"; 
$dbname = "postgres"; 
$user = "postgres"; 
$password = "fabri10+100"; 

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $conexion = new PDO($dsn, $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a Supabase: " . $e->getMessage());
}
?>

