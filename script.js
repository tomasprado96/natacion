
let competidores = [];
let resultados = [];
let asignaciones = {};

function registrarCompetidor() {
    const nombre = document.getElementById('nombre').value.trim();
    const estilo = document.getElementById('estilo').value;
    const distancia = document.getElementById('distancia').value;

    if (nombre === '') {
        alert('El nombre del competidor es obligatorio.');
        return;
    }

    competidores.push({ nombre, estilo, distancia });
    document.getElementById('registroForm').reset();
    mostrarCompetidores();
}

function asignarCarriles(numCarriles) {
    if (competidores.length === 0) {
        alert('No hay competidores para asignar carriles.');
        return;
    }

    const carriles = Array.from({ length: numCarriles }, (_, i) => i + 1);
    competidores.forEach((competidor, index) => {
        const carril = carriles[index % numCarriles];
        asignaciones[competidor.nombre] = carril;
    });
    mostrarCarriles();
}

function agregarResultado() {
    const nombre = document.getElementById('resultadoNombre').value.trim();
    const estilo = document.getElementById('resultadoEstilo').value;
    const distancia = document.getElementById('resultadoDistancia').value;
    const tiempo = parseFloat(document.getElementById('tiempo').value);

    if (nombre === '' || isNaN(tiempo)) {
        alert('Debe ingresar un nombre válido y un tiempo.');
        return;
    }

    resultados.push({ nombre, estilo, distancia, tiempo });
    document.getElementById('resultadoForm').reset();
    mostrarResultados();
}

function consultarPrimerPuesto() {
    const primerPuesto = {};
    resultados.forEach(resultado => {
        const clave = `${resultado.estilo}-${resultado.distancia}`;
        if (!primerPuesto[clave] || resultado.tiempo < primerPuesto[clave].tiempo) {
            primerPuesto[clave] = resultado;
        }
    });
    document.getElementById('resultados').innerHTML = formatearResultados(primerPuesto, '1° Puesto');
}

function resultadosPorEstilo(estilo) {
    const filtrados = resultados.filter(r => r.estilo === estilo);
    const ordenados = filtrados.sort((a, b) => a.tiempo - b.tiempo);
    document.getElementById('resultados').innerHTML = formatearResultados(ordenados, `Resultados ${estilo}`);
}

function formatearResultados(data, titulo) {
    let result = `<h3>${titulo}</h3>`;
    if (Array.isArray(data)) {
        data.forEach((item, index) => {
            result += `<p>${index + 1}° Puesto: ${item.nombre} - ${item.estilo} - ${item.distancia} metros - ${formatTime(item.tiempo)}</p>`;
        });
    } else {
        Object.keys(data).forEach(key => {
            const item = data[key];
            result += `<p>${key}: ${item.nombre} - ${item.estilo} - ${item.distancia} metros - ${formatTime(item.tiempo)}</p>`;
        });
    }
    return result;
}

function formatTime(tiempo) {
    const minutos = Math.floor(tiempo / 60);
    const segundos = Math.floor(tiempo % 60);
    const centesimas = Math.round((tiempo % 1) * 100);
    return `${String(minutos).padStart(2, '0')}:${String(segundos).padStart(2, '0')}:${String(centesimas).padStart(2, '0')}`;
}

function mostrarCompetidores() {
    const competidoresList = competidores.map(c => `Nombre: ${c.nombre}, Estilo: ${c.estilo}, Distancia: ${c.distancia}`).join('<br>');
    document.getElementById('competidores').innerHTML = `<div class="section-title">Competidores</div>${competidoresList}`;
}

function mostrarCarriles() {
    const carrilesList = Object.keys(asignaciones).map(nombre => `Nombre: ${nombre}, Carril: ${asignaciones[nombre]}`).join('<br>');
    document.getElementById('carriles').innerHTML = `<div class="section-title">Carriles Asignados</div>${carrilesList}`;
}

function mostrarResultados() {
    const resultadosList = resultados.map(r => `Nombre: ${r.nombre}, Estilo: ${r.estilo}, Distancia: ${r.distancia} metros, Tiempo: ${formatTime(r.tiempo)}`).join('<br>');
    document.getElementById('resultados').innerHTML = `<div class="section-title">Resultados</div>${resultadosList}`;
}

function mostrarTodo() {
    mostrarCompetidores();
    mostrarCarriles();
    mostrarResultados();
}