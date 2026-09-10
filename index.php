<?php
require_once 'conexion.php';

$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$categoria_filtro = isset($_GET['categoria_filtro']) ? $_GET['categoria_filtro'] : '';
$estado_filtro = isset($_GET['estado_filtro']) ? $_GET['estado_filtro'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario del Laboratorio Informático</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h1>Inventario del Laboratorio Informático</h1>

        <?php if ($mensaje == 'exito_guardar'): ?>
            <div class="alert alert-success">Componente registrado correctamente.</div>
        <?php elseif ($mensaje == 'exito_actualizar'): ?>
            <div class="alert alert-success">Componente actualizado correctamente.</div>
        <?php elseif ($mensaje == 'exito_eliminar'): ?>
            <div class="alert alert-success">Componente eliminado correctamente.</div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Sección: Registrar Componente -->
        <div class="card">
            <h2>Registrar Nuevo Componente</h2>
            <form action="guardar.php" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="codigo">Código *</label>
                        <input type="text" id="codigo" name="codigo" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría *</label>
                        <select id="categoria" name="categoria" required>
                            <option value="">Seleccione...</option>
                            <option value="Computadoras">Computadoras</option>
                            <option value="Monitores">Monitores</option>
                            <option value="Periféricos">Periféricos</option>
                            <option value="Componentes electrónicos">Componentes electrónicos</option>
                            <option value="Herramientas">Herramientas</option>
                            <option value="Redes">Redes</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <input type="text" id="marca" name="marca">
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad *</label>
                        <input type="number" id="cantidad" name="cantidad" min="0" value="1" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado *</label>
                        <select id="estado" name="estado" required>
                            <option value="">Seleccione...</option>
                            <option value="Disponible">Disponible</option>
                            <option value="En uso">En uso</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_registro">Fecha de Registro *</label>
                        <input type="date" id="fecha_registro" name="fecha_registro" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion"></textarea>
                    </div>
                </div>
                <div style="margin-top: 15px;">
                    <button type="submit" class="btn">Guardar Componente</button>
                </div>
            </form>
        </div>

        <!-- Sección: Buscador y Filtros -->
        <div class="card filtros-container">
            <h2>Buscador y Filtros</h2>
            <form action="index.php" method="GET">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="busqueda">Buscar (Código, Nombre o Marca):</label>
                        <input type="text" id="busqueda" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Escriba aquí...">
                    </div>
                    <div class="form-group">
                        <label for="categoria_filtro">Filtrar por Categoría:</label>
                        <select id="categoria_filtro" name="categoria_filtro">
                            <option value="">Todas las categorías</option>
                            <option value="Computadoras" <?php if($categoria_filtro == 'Computadoras') echo 'selected'; ?>>Computadoras</option>
                            <option value="Monitores" <?php if($categoria_filtro == 'Monitores') echo 'selected'; ?>>Monitores</option>
                            <option value="Periféricos" <?php if($categoria_filtro == 'Periféricos') echo 'selected'; ?>>Periféricos</option>
                            <option value="Componentes electrónicos" <?php if($categoria_filtro == 'Componentes electrónicos') echo 'selected'; ?>>Componentes electrónicos</option>
                            <option value="Herramientas" <?php if($categoria_filtro == 'Herramientas') echo 'selected'; ?>>Herramientas</option>
                            <option value="Redes" <?php if($categoria_filtro == 'Redes') echo 'selected'; ?>>Redes</option>
                            <option value="Otros" <?php if($categoria_filtro == 'Otros') echo 'selected'; ?>>Otros</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="estado_filtro">Filtrar por Estado:</label>
                        <select id="estado_filtro" name="estado_filtro">
                            <option value="">Todos los estados</option>
                            <option value="Disponible" <?php if($estado_filtro == 'Disponible') echo 'selected'; ?>>Disponible</option>
                            <option value="En uso" <?php if($estado_filtro == 'En uso') echo 'selected'; ?>>En uso</option>
                            <option value="Reparación" <?php if($estado_filtro == 'Reparación') echo 'selected'; ?>>Reparación</option>
                            <option value="Baja" <?php if($estado_filtro == 'Baja') echo 'selected'; ?>>Baja</option>
                        </select>
                    </div>
                    <div class="form-group" style="justify-content: flex-end;">
                        <button type="submit" class="btn">Buscar / Filtrar</button>
                    </div>
                    <div class="form-group" style="justify-content: flex-end;">
                        <a href="index.php" class="btn btn-secondary">Limpiar Filtros</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sección: Tabla de Registros -->
        <div class="card">
            <h2>Lista de Componentes</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consulta en PostgreSQL usando PDO
                        $sql = "SELECT * FROM componentes WHERE 1=1";
                        $parametros = [];

                        if (!empty($busqueda)) {
                            // En Postgres usamos ILIKE para que no importe mayúsculas/minúsculas
                            $sql .= " AND (codigo ILIKE ? OR nombre ILIKE ? OR marca ILIKE ?)";
                            $param_busqueda = "%" . $busqueda . "%";
                            $parametros[] = $param_busqueda;
                            $parametros[] = $param_busqueda;
                            $parametros[] = $param_busqueda;
                        }

                        if (!empty($categoria_filtro)) {
                            $sql .= " AND categoria = ?";
                            $parametros[] = $categoria_filtro;
                        }

                        if (!empty($estado_filtro)) {
                            $sql .= " AND estado = ?";
                            $parametros[] = $estado_filtro;
                        }

                        $sql .= " ORDER BY id DESC";

                        try {
                            $stmt = $conexion->prepare($sql);
                            $stmt->execute($parametros);
                            
                            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($resultados) > 0) {
                                foreach ($resultados as $fila) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($fila['id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['codigo']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['categoria']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['marca']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['cantidad']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['estado']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['descripcion']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['fecha_registro']) . "</td>";
                                    echo "<td class='acciones'>";
                                    echo "<a href='editar.php?id=" . htmlspecialchars($fila['id']) . "' class='btn btn-warning'>Editar</a>";
                                    echo "<a href='eliminar.php?id=" . htmlspecialchars($fila['id']) . "' class='btn btn-danger'>Eliminar</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron registros.</td></tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='10' style='text-align:center; color:red;'>Error en la consulta: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>