<?php
// Configuración de la base de datos SUPABASE (PostgreSQL)

$host = "aws-0-us-east-2.pooler.supabase.com"; // <- ¡Usa el host del Transaction Pooler!
$port = "6543";                                // <- El puerto cambia a 6543
$dbname = "postgres";
$user = "postgres.zejwgocnnunpgbyooxbw";       // <- Fíjate en tu panel, a veces le agregan el ID al usuario
$password = "fabri10+100";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $conexion = new PDO($dsn, $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a Supabase: " . $e->getMessage());
}
?>
