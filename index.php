<?php
require_once 'conexion.php';

$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$categoria_filtro = isset($_GET['categoria_filtro']) ? $_GET['categoria_filtro'] : '';
$estado_filtro = isset($_GET['estado_filtro']) ? $_GET['estado_filtro'] : '';

// Función auxiliar en PHP para asignar el color del "Badge" de estado sin usar JS
function obtenerClaseEstado($estado) {
    switch ($estado) {
        case 'Disponible': return 'badge-disponible';
        case 'En uso': return 'badge-en-uso';
        case 'Reparación': return 'badge-reparacion';
        case 'Baja': return 'badge-baja';
        default: return '';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStock | Dashboard de Inventario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <!-- NAVBAR TECHSTOCK -->
    <header class="navbar">
        <div class="navbar-brand">
            <!-- Icono HTML de una caja/servidor para darle estilo Tech -->
            &#128421; Tech<span>Stock</span>
        </div>
        <div class="navbar-subtitle">
            Gestión de Equipos Informáticos
        </div>
    </header>

    <div class="container">

        <?php if ($mensaje == 'exito_guardar'): ?>
            <div class="alert alert-success">&#10004; Componente registrado correctamente en el sistema.</div>
        <?php elseif ($mensaje == 'exito_actualizar'): ?>
            <div class="alert alert-success">&#10004; Ficha del componente actualizada correctamente.</div>
        <?php elseif ($mensaje == 'exito_eliminar'): ?>
            <div class="alert alert-success">&#10004; Componente eliminado del inventario permanentemente.</div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">&#9888; <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Sección: Buscador y Filtros -->
        <div class="card" style="border-top: 4px solid var(--primary);">
            <div class="card-header">&#128269; Filtrar y Buscar Equipos</div>
            <form action="index.php" method="GET">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="busqueda">Término de búsqueda</label>
                        <input type="text" id="busqueda" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Ej: Monitor, SN-124, Dell...">
                    </div>
                    <div class="form-group">
                        <label for="categoria_filtro">Categoría</label>
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
                        <label for="estado_filtro">Estado Operativo</label>
                        <select id="estado_filtro" name="estado_filtro">
                            <option value="">Todos los estados</option>
                            <option value="Disponible" <?php if($estado_filtro == 'Disponible') echo 'selected'; ?>>Disponible</option>
                            <option value="En uso" <?php if($estado_filtro == 'En uso') echo 'selected'; ?>>En uso</option>
                            <option value="Reparación" <?php if($estado_filtro == 'Reparación') echo 'selected'; ?>>Reparación</option>
                            <option value="Baja" <?php if($estado_filtro == 'Baja') echo 'selected'; ?>>Baja</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex: 0 1 auto; justify-content: flex-end;">
                        <button type="submit" class="btn">Aplicar Filtros</button>
                    </div>
                    <div class="form-group" style="flex: 0 1 auto; justify-content: flex-end;">
                        <a href="index.php" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sección: Registrar Componente -->
        <div class="card">
            <div class="card-header">&#10133; Registrar Nuevo Equipo</div>
            <form action="guardar.php" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="codigo">Código (SKU) *</label>
                        <input type="text" id="codigo" name="codigo" placeholder="Ej: PC-001" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre del Equipo *</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: Notebook Dell Latitude" required>
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
                        <label for="marca">Marca de Fabricante</label>
                        <input type="text" id="marca" name="marca" placeholder="Ej: Dell, HP, Cisco...">
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Unidades *</label>
                        <input type="number" id="cantidad" name="cantidad" min="0" value="1" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado Inicial *</label>
                        <select id="estado" name="estado" required>
                            <option value="">Seleccione...</option>
                            <option value="Disponible">Disponible</option>
                            <option value="En uso">En uso</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_registro">Fecha de Ingreso *</label>
                        <input type="date" id="fecha_registro" name="fecha_registro" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="descripcion">Notas / Especificaciones Técnicas</label>
                        <textarea id="descripcion" name="descripcion" placeholder="Procesador, RAM, problemas conocidos..."></textarea>
                    </div>
                </div>
                <div style="margin-top: 20px; text-align: right;">
                    <button type="submit" class="btn">&#128190; Guardar en Inventario</button>
                </div>
            </form>
        </div>

        <!-- Sección: Tabla de Registros -->
        <div class="card">
            <div class="card-header">&#128450; Base de Datos de Equipos</div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Equipo</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Cant.</th>
                            <th>Estado</th>
                            <th>Ingreso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consulta en PostgreSQL (Supabase) usando PDO
                        $sql = "SELECT * FROM componentes WHERE 1=1";
                        $parametros = [];

                        if (!empty($busqueda)) {
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
                                    $clase_estado = obtenerClaseEstado($fila['estado']);
                                    
                                    echo "<tr>";
                                    echo "<td><strong>" . htmlspecialchars($fila['codigo']) . "</strong></td>";
                                    echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['categoria']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['marca']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['cantidad']) . "</td>";
                                    echo "<td><span class='badge " . $clase_estado . "'>" . htmlspecialchars($fila['estado']) . "</span></td>";
                                    echo "<td>" . htmlspecialchars($fila['fecha_registro']) . "</td>";
                                    echo "<td class='acciones'>";
                                    echo "<a href='editar.php?id=" . htmlspecialchars($fila['id']) . "' class='btn btn-sm btn-warning'>Editar</a>";
                                    echo "<a href='eliminar.php?id=" . htmlspecialchars($fila['id']) . "' class='btn btn-sm btn-danger'>Borrar</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' style='text-align:center; padding: 30px; color: #94a3b8;'>No se encontraron equipos en el inventario.</td></tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='8' style='text-align:center; color:red;'>Error en la consulta: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>