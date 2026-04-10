<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Notas</title>
    <link rel="stylesheet" href="assets/styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

    <div class="container">
        <h1>Sistema de Registro de Notas</h1>

        <div class="card">
            <h2>Registrar / Actualizar Nota</h2>

            <form id="notaForm">
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
                        max="20"
                        step="0.01"
                        placeholder="Ej: 18.5"
                        required
                    >
                </div>

                <div class="buttons">
                    <button type="submit" id="btnGuardar">Guardar</button>
                    <button type="button" id="btnCancelar" class="secondary" style="display: none;">
                        Cancelar
                    </button>
                </div>
            </form>

            <p id="mensaje"></p>
        </div>

        <div class="card promedio-card">
            <h2>Promedio General</h2>
            <div id="promedioBox">0.00</div>
        </div>

        <div class="card">
            <h2>Listado de Notas</h2>

            <div class="table-responsive">
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
        </div>
    </div>

    <script src="assets/app.js"></script>
</body>
</html>