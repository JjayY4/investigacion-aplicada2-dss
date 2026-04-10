<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Notas</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

    <main class="app-shell">
        <section class="hero">
            <div class="hero__text">
                <span class="badge">Sistema académico</span>
                <h1>Registro de Notas</h1>
            </div>
        </section>

        <section class="grid">
            <div class="panel panel--form">
                <div class="panel__header">
                    <h2>Registrar / Actualizar</h2>
                    <span class="panel__subtitle">Formulario de notas</span>
                </div>

                <form id="notaForm" class="form">
                    <input type="hidden" id="id" name="id">

                    <div class="form-group">
                        <label for="estudiante_id">Estudiante</label>
                        <select id="estudiante_id" name="estudiante_id" required>
                            <option value="">Seleccione un estudiante</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="asignatura">Asignatura</label>
                        <input
                            type="text"
                            id="asignatura"
                            name="asignatura"
                            placeholder="Ej: Matemática"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="nota">Nota</label>
                        <input
                            type="number"
                            id="nota"
                            name="nota"
                            min="0"
                            max="10"
                            step="0.01"
                            placeholder="Ej: 6.50"
                            required
                        >
                    </div>

                    <div class="buttons">
                        <button type="submit" id="btnGuardar" class="btn btn--primary">Guardar</button>
                        <button type="button" id="btnCancelar" class="btn btn--ghost" style="display:none;">
                            Cancelar
                        </button>
                    </div>
                </form>

                <p id="mensaje" class="message"></p>
            </div>

            <div class="side">
                <div class="panel panel--metric">
                    <div class="panel__header">
                        <h2>Promedio General</h2>
                        <span class="panel__subtitle">Cálculo automático</span>
                    </div>
                    <div class="metric">
                        <span id="promedioBox">0.00</span>
                        <small>sobre 10 puntos</small>
                    </div>
                </div>

                <div class="panel panel--info">
                    <div class="panel__header">
                        <h2>Resumen</h2>
                        <span class="panel__subtitle">Uso del sistema</span>
                    </div>
                    <p class="info-text">
                        Selecciona un estudiante, registra su asignatura y su nota. También puedes editar un registro existente desde la tabla inferior.
                    </p>
                </div>
            </div>
        </section>

        <section class="panel panel--table">
            <div class="panel__header">
                <h2>Listado de Notas</h2>
                <span class="panel__subtitle">Registros almacenados</span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Estudiante</th>
                            <th>Asignatura</th>
                            <th>Nota</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tablaNotas">
                        <tr>
                            <td colspan="5">Cargando notas...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <div id="modalOverlay" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon">🗑️</div>
        <h3>Eliminar registro</h3>
        <p id="modalText">¿Seguro que deseas eliminar esta nota?</p>

        <div class="modal-actions">
            <button type="button" id="confirmDelete" class="btn btn--danger">Sí, eliminar</button>
            <button type="button" id="cancelDelete" class="btn btn--ghost">Cancelar</button>
        </div>
    </div>
</div>

    <script src="assets/app.js"></script>
</body>
</html>