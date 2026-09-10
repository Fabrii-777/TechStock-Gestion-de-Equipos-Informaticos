<?php
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int) $_POST['id'];
    $codigo = trim($_POST['codigo']);
    $nombre = trim($_POST['nombre']);
    $categoria = trim($_POST['categoria']);
    $marca = trim($_POST['marca']);
    $cantidad = (int) $_POST['cantidad'];
    $estado = trim($_POST['estado']);
    $fecha_registro = trim($_POST['fecha_registro']);
    $descripcion = trim($_POST['descripcion']);

    if (empty($codigo) || empty($nombre) || empty($categoria) || empty($estado) || empty($fecha_registro) || $id <= 0) {
        header("Location: index.php?error=" . urlencode("Faltan campos obligatorios."));
        exit();
    }

    if ($cantidad < 0) {
        header("Location: index.php?error=" . urlencode("La cantidad no puede ser negativa."));
        exit();
    }

    try {
        $stmt_check = $conexion->prepare("SELECT id FROM componentes WHERE codigo = ? AND id != ?");
        $stmt_check->execute([$codigo, $id]);
        
        if ($stmt_check->rowCount() > 0) {
            header("Location: index.php?error=" . urlencode("Error: El código ingresado ya pertenece a otro componente."));
            exit();
        }

        $sql = "UPDATE componentes SET codigo=?, nombre=?, categoria=?, marca=?, cantidad=?, estado=?, descripcion=?, fecha_registro=? WHERE id=?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$codigo, $nombre, $categoria, $marca, $cantidad, $estado, $descripcion, $fecha_registro, $id]);

        header("Location: index.php?mensaje=exito_actualizar");
        
    } catch (PDOException $e) {
        header("Location: index.php?error=" . urlencode("Error al actualizar: " . $e->getMessage()));
    }
} else {
    header("Location: index.php");
}
?>