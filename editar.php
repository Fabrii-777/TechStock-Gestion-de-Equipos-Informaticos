<?php
require_once 'conexion.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];

try {
    $sql = "SELECT * FROM componentes WHERE id = ?";
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
    <title>Editar Componente</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h1>Editar Componente</h1>
        <div class="card">
            <form action="actualizar.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($componente['id']); ?>">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="codigo">Código *</label>
                        <input type="text" id="codigo" name="codigo" value="<?php echo htmlspecialchars($componente['codigo']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($componente['nombre']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría *</label>
                        <select id="categoria" name="categoria" required>
                            <option value="Computadoras" <?php if($componente['categoria'] == 'Computadoras') echo 'selected'; ?>>Computadoras</option>
                            <option value="Monitores" <?php if($componente['categoria'] == 'Monitores') echo 'selected'; ?>>Monitores</option>
                            <option value="Periféricos" <?php if($componente['categoria'] == 'Periféricos') echo 'selected'; ?>>Periféricos</option>
                            <option value="Componentes electrónicos" <?php if($componente['categoria'] == 'Componentes electrónicos') echo 'selected'; ?>>Componentes electrónicos</option>
                            <option value="Herramientas" <?php if($componente['categoria'] == 'Herramientas') echo 'selected'; ?>>Herramientas</option>
                            <option value="Redes" <?php if($componente['categoria'] == 'Redes') echo 'selected'; ?>>Redes</option>
                            <option value="Otros" <?php if($componente['categoria'] == 'Otros') echo 'selected'; ?>>Otros</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($componente['marca']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad *</label>
                        <input type="number" id="cantidad" name="cantidad" min="0" value="<?php echo htmlspecialchars($componente['cantidad']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado *</label>
                        <select id="estado" name="estado" required>
                            <option value="Disponible" <?php if($componente['estado'] == 'Disponible') echo 'selected'; ?>>Disponible</option>
                            <option value="En uso" <?php if($componente['estado'] == 'En uso') echo 'selected'; ?>>En uso</option>
                            <option value="Reparación" <?php if($componente['estado'] == 'Reparación') echo 'selected'; ?>>Reparación</option>
                            <option value="Baja" <?php if($componente['estado'] == 'Baja') echo 'selected'; ?>>Baja</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_registro">Fecha de Registro *</label>
                        <input type="date" id="fecha_registro" name="fecha_registro" value="<?php echo htmlspecialchars($componente['fecha_registro']); ?>" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($componente['descripcion']); ?></textarea>
                    </div>
                </div>
                <div style="margin-top: 15px; display: flex; gap: 10px;">
                    <button type="submit" class="btn">Actualizar Componente</button>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>