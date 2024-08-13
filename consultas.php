<?php
include("sql.php");

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch($action) {
    case 'asignarCarriles':
        asignarCarriles();
        break;
    case 'consultarPrimerPuesto':
        consultarPrimerPuesto();
        break;
    case 'consultarMejorNadador':
        consultarMejorNadador($_GET['estilo']);
        break;
    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}

function asignarCarriles() {
    global $sql;

    // Obtener todos los competidores
    $query = "SELECT id, nombre FROM competidores";
    $result = $sql->query($query);
    $competidores = $result->fetch_all(MYSQLI_ASSOC);

    // Asignar carriles (suponiendo 5 carriles disponibles, si hay más competidores que carriles, se asignan en orden)
    $carriles = [];
    $numCarriles = 5;
    foreach ($competidores as $index => $competidor) {
        $carril = ($index % $numCarriles) + 1;
        $carriles[] = ['id' => $competidor['id'], 'nombre' => $competidor['nombre'], 'carril' => $carril];
    }

    // Enviar la asignación de carriles como JSON
    echo json_encode($carriles);
}

function consultarPrimerPuesto() {
    global $sql;

    $query = "SELECT nombre, estilo, distancia, tiempo FROM resultados ORDER BY tiempo ASC LIMIT 1";
    $result = $sql->query($query);
    $primerPuesto = $result->fetch_assoc();

    echo json_encode($primerPuesto);
}

function consultarMejorNadador($estilo) {
    global $sql;

    $query = "SELECT nombre, estilo, distancia, tiempo FROM resultados WHERE estilo = ? ORDER BY tiempo ASC LIMIT 1";
    $stmt = $sql->prepare($query);
    $stmt->bind_param("s", $estilo);
    $stmt->execute();
    $result = $stmt->get_result();
    $mejorNadador = $result->fetch_assoc();

    echo json_encode($mejorNadador);
}
?>
