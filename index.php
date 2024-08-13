<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Competidores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Registro de Competidor</h2>
    <form id="registroForm" method="post" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="estilo">Estilo:</label>
        <select id="estilo" name="estilo" required>
            <option value="Pecho">Pecho</option>
            <option value="Crol">Crol</option>
            <option value="Espalda">Espalda</option>
            <option value="Mariposa">Mariposa</option>
        </select>
        
        <label for="distancia">Distancia:</label>
        <select id="distancia" name="distancia" required>
            <option value="25">25 metros</option>
            <option value="50">50 metros</option>
            <option value="100">100 metros</option>
        </select>
        
        <button type="submit" name="submitCompetidor">Registrar</button>
    </form>

    <div>
        <h2>Asignación de Carriles</h2>
        <button onclick="asignarCarriles(5)">Asignar Carriles</button>
    </div>

 
    <div id="competidores" class="section">
        <div class="section-title">Competidores</div>
    </div>

    <div id="carriles" class="section">
        <div class="section-title">Carriles Asignados</div>
    </div>

    <div id="resultados" class="section">
        <div class="section-title">Resultados</div>
    </div>

    <h2>Agregar Resultados</h2>
    <form id="resultadoForm" method="post" action="">
        <label for="resultadoNombre">Nombre:</label>
        <input type="text" id="resultadoNombre" name="nombre" required>
        
        <label for="resultadoEstilo">Estilo:</label>
        <select id="resultadoEstilo" name="estilo" required>
            <option value="Pecho">Pecho</option>
            <option value="Crol">Crol</option>
            <option value="Espalda">Espalda</option>
            <option value="Mariposa">Mariposa</option>
        </select>
        
        <label for="resultadoDistancia">Distancia:</label>
        <select id="resultadoDistancia" name="distancia" required>
            <option value="25">25 metros</option>
            <option value="50">50 metros</option>
            <option value="100">100 metros</option>
        </select>
        
        <label for="tiempo">Tiempo:</label>
        <input type="number" step="0.01" id="tiempo" name="tiempo" required>
        
        <button type="submit" name="submitResultado">Agregar Resultado</button>
    </form>

    <h2>Consultas</h2>
    <button onclick="consultarPrimerPuesto()">Consultar 1° Puesto</button>
    <button onclick="resultadosPorEstilo('Crol')">Consultar Resultados Crol</button>
    <button onclick="resultadosPorEstilo('Pecho')">Consultar Resultados Pecho</button>
    <button onclick="resultadosPorEstilo('Espalda')">Consultar Resultados Espalda</button>
    <button onclick="resultadosPorEstilo('Mariposa')">Consultar Resultados Mariposa</button>

    <script src="script.js"></script>

    <?php
    include("sql.php");

    // Handle Competitor Registration
    if (isset($_POST['submitCompetidor'])) {
        $nombre = trim($_POST['nombre']);
        $estilo = trim($_POST['estilo']);
        $distancia = trim($_POST['distancia']);
        
        if (strlen($nombre) >= 1 && strlen($estilo) >= 1 && strlen($distancia) >= 1) {
            $query = "INSERT INTO competidores (nombre, estilo, distancia) VALUES (?, ?, ?)";
            $stmt = $sql->prepare($query);
            $stmt->bind_param("ssi", $nombre, $estilo, $distancia);

            if ($stmt->execute()) {
                echo "<p>Competidor ingresado</p>";
            } else {
                echo "<p>Error al ingresar el competidor: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p>Todos los campos son requeridos</p>";
        }
    }

    // Handle Result Addition
    if (isset($_POST['submitResultado'])) {
        $resultadoNombre = trim($_POST['nombre']);
        $resultadoEstilo = trim($_POST['estilo']);
        $resultadoDistancia = trim($_POST['distancia']);
        $tiempo = trim($_POST['tiempo']);
        
        if (strlen($resultadoNombre) >= 1 && strlen($resultadoEstilo) >= 1 && strlen($resultadoDistancia) >= 1 && strlen($tiempo) >= 1) {
            $query = "INSERT INTO resultados (nombre, estilo, distancia, tiempo) VALUES (?, ?, ?, ?)";
            $stmt = $sql->prepare($query);
            $stmt->bind_param("ssid", $resultadoNombre, $resultadoEstilo, $resultadoDistancia, $tiempo);

            if ($stmt->execute()) {
                echo "<p>Resultado agregado</p>";
            } else {
                echo "<p>Error al agregar el resultado: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p>Todos los campos son requeridos</p>";
        }
    }
    ?>
    <script src="script.js"></script>
</body>
</html>
