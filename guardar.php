<?php
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = trim($_POST['codigo']);
    $nombre = trim($_POST['nombre']);
    $categoria = trim($_POST['categoria']);
    $marca = trim($_POST['marca']);
    $cantidad = (int) $_POST['cantidad'];
    $estado = trim($_POST['estado']);
    $fecha_registro = trim($_POST['fecha_registro']);
    $descripcion = trim($_POST['descripcion']);

    if (empty($codigo) || empty($nombre) || empty($categoria) || empty($estado) || empty($fecha_registro)) {
        header("Location: index.php?error=" . urlencode("Faltan campos obligatorios."));
        exit();
    }

    if ($cantidad < 0) {
        header("Location: index.php?error=" . urlencode("La cantidad no puede ser negativa."));
        exit();
    }

    try {
        $stmt_check = $conexion->prepare("SELECT id FROM componentes WHERE codigo = ?");
        $stmt_check->execute([$codigo]);
        
        if ($stmt_check->rowCount() > 0) {
            header("Location: index.php?error=" . urlencode("Error: El código (SKU) ingresado ya existe en TechStock."));
            exit();
        }

        $sql = "INSERT INTO componentes (codigo, nombre, categoria, marca, cantidad, estado, descripcion, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$codigo, $nombre, $categoria, $marca, $cantidad, $estado, $descripcion, $fecha_registro]);

        header("Location: index.php?mensaje=exito_guardar");
        
    } catch (PDOException $e) {
        header("Location: index.php?error=" . urlencode("Error de base de datos: " . $e->getMessage()));
    }
} else {
    header("Location: index.php");
    exit();
}
?>