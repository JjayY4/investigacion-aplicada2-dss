<form method="POST" action="api.php">
    <input type="hidden" name="action" value="create">

    <label>Estudiante ID:</label>
    <input type="number" name="estudiante_id"><br><br>

    <label>Asignatura:</label>
    <input type="text" name="asignatura"><br><br>

    <label>Nota:</label>
    <input type="number" step="0.01" name="nota"><br><br>

    <button type="submit">Probar registro</button>
</form>