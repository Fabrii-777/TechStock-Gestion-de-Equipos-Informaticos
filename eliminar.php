<?php
require_once 'conexion.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];

// Si se confirma la eliminación mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar'])) {
    try {
        $sql = "DELETE FROM componentes WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
        
        header("Location: index.php?mensaje=exito_eliminar");
        exit();
    } catch (PDOException $e) {
        header("Location: index.php?error=" . urlencode("Error al eliminar: " . $e->getMessage()));
        exit();
    }
}

// Si no, mostrar formulario de confirmación
try {
    $sql = "SELECT codigo, nombre FROM componentes WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id]);
    $componente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$componente) {
        header("Location: index.php?error=" . urlencode("Registro no encontrado."));
        exit();
    }
} catch (PDOException $e) {
    header("Location: index.php?error=" . urlencode("Error: " . $e->getMessage()));
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Eliminación</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <div class="card confirm-box">
            <h2>¿Está seguro de que desea eliminar este componente?</h2>
            <p><strong>Código:</strong> <?php echo htmlspecialchars($componente['codigo']); ?></p>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($componente['nombre']); ?></p>
            <p style="color: #e74c3c; font-size: 14px; margin-top: 15px;">Esta acción no se puede deshacer.</p>
            
            <form action="eliminar.php?id=<?php echo $id; ?>" method="POST" style="margin-top: 20px;">
                <input type="hidden" name="confirmar" value="1">
                <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>