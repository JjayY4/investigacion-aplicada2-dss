$(document).ready(function () {
    cargarEstudiantes();
    listarNotas();
    cargarPromedio();

    $('#notaForm').on('submit', function (e) {
        e.preventDefault();

        const id = $('#id').val().trim();
        const estudianteId = $('#estudiante_id').val();
        const asignatura = $('#asignatura').val().trim();
        const nota = $('#nota').val().trim();

        if (estudianteId === '' || asignatura === '' || nota === '') {
            mostrarMensaje('Completa todos los campos.', false);
            return;
        }

        const action = id === '' ? 'create' : 'update';

        $.ajax({
            url: 'api.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: action,
                id: id,
                estudiante_id: estudianteId,
                asignatura: asignatura,
                nota: nota
            },
            success: function (res) {
                mostrarMensaje(res.message, res.success);

                if (res.success) {
                    limpiarFormulario();
                    listarNotas();
                    cargarPromedio();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error AJAX:', error);
                console.error('Respuesta:', xhr.responseText);
                mostrarMensaje('Ocurrió un error al comunicarse con el servidor.', false);
            }
        });
    });

    $('#btnCancelar').on('click', function () {
        limpiarFormulario();
        mostrarMensaje('', true);
    });
});

function cargarEstudiantes() {
    $.ajax({
        url: 'api.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'students' },
        success: function (res) {
            let opciones = '<option value="">Seleccione un estudiante</option>';

            if (res.success && Array.isArray(res.data)) {
                res.data.forEach(function (student) {
                    opciones += `<option value="${student.id}">${student.nombre}</option>`;
                });
            }

            $('#estudiante_id').html(opciones);
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            mostrarMensaje('No se pudieron cargar los estudiantes.', false);
        }
    });
}

function listarNotas() {
    $.ajax({
        url: 'api.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'list' },
        success: function (res) {
            let html = '';

            if (res.success && Array.isArray(res.data) && res.data.length > 0) {
                res.data.forEach(function (item) {
                    html += `
                        <tr>
                            <td>${item.id}</td>
                            <td>${item.estudiante}</td>
                            <td>${item.asignatura}</td>
                            <td>${item.nota}</td>
                            <td>
                                <button type="button" class="edit-btn" onclick="editarNota(${item.id})">
                                    Editar
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                const nota = parseFloat(item.nota);
                let claseNota = 'nota-baja';

                if (nota >= 8) {
                    claseNota = 'nota-alta';
                } else if (nota >= 5) {
                    claseNota = 'nota-media';
                }

                html += `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.estudiante}</td>
                        <td>${item.asignatura}</td>
                        <td class="${claseNota}">${nota.toFixed(2)}</td>
                        <td>
                            <button type="button" class="edit-btn" onclick="editarNota(${item.id})">
                                Editar
                            </button>
                        </td>
                    </tr>
                `;
            }

            $('#tablaNotas').html(html);
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            $('#tablaNotas').html(`
                <tr>
                    <td colspan="5">Error al cargar las notas.</td>
                </tr>
            `);
        }
    });
}

function cargarPromedio() {
    $.ajax({
        url: 'api.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'average' },
        success: function (res) {
            if (res.success && res.data) {
                const promedio = parseFloat(res.data.promedio ?? 0);

                let clase = 'nota-baja';

                if (promedio >= 8) {
                    clase = 'nota-alta';
                } else if (promedio >= 5) {
                    clase = 'nota-media';
                }
                $('#promedioBox')
                    .removeClass('nota-alta nota-media nota-baja')
                    .addClass(clase)
                    .text(promedio.toFixed(2));
            } else {
                $('#promedioBox').text('0.00');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            $('#promedioBox').text('0.00');
        }
    });
}

function editarNota(id) {
    $.ajax({
        url: 'api.php',
        type: 'GET',
        dataType: 'json',
        data: {
            action: 'get',
            id: id
        },
        success: function (res) {
            if (res.success && res.data) {
                $('#id').val(res.data.id);
                $('#estudiante_id').val(res.data.estudiante_id);
                $('#asignatura').val(res.data.asignatura);
                $('#nota').val(res.data.nota);

                $('#btnGuardar').text('Actualizar');
                $('#btnCancelar').show();

                $('html, body').animate({
                    scrollTop: 0
                }, 400);

                mostrarMensaje('Editando registro #' + res.data.id, true);
            } else {
                mostrarMensaje(res.message || 'No se pudo cargar la nota.', false);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            mostrarMensaje('Error al obtener los datos de la nota.', false);
        }
    });
}

function limpiarFormulario() {
    $('#notaForm')[0].reset();
    $('#id').val('');
    $('#btnGuardar').text('Guardar');
    $('#btnCancelar').hide();
}

function mostrarMensaje(texto, esExito) {
    $('#mensaje')
        .text(texto)
        .removeClass('ok error')
        .addClass(esExito ? 'ok' : 'error');
}