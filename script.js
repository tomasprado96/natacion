document.addEventListener("DOMContentLoaded", () => {
    // Asignar carriles a los competidores
    function asignarCarriles() {
        fetch('consultas.php?action=asignarCarriles')
            .then(response => response.json())
            .then(data => {
                const carrilesDiv = document.getElementById('carriles');
                carrilesDiv.innerHTML = '<div class="section-title">Carriles Asignados</div>';
                data.forEach(c => {
                    const div = document.createElement('div');
                    div.textContent = `Competidor: ${c.nombre} - Carril: ${c.carril}`;
                    carrilesDiv.appendChild(div);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Consultar primer puesto
    function consultarPrimerPuesto() {
        fetch('consultas.php?action=consultarPrimerPuesto')
            .then(response => response.json())
            .then(data => {
                const resultadosDiv = document.getElementById('resultados');
                resultadosDiv.innerHTML = `
                    <div class="section-title">Primer Puesto</div>
                    <p>Nombre: ${data.nombre}</p>
                    <p>Estilo: ${data.estilo}</p>
                    <p>Distancia: ${data.distancia} metros</p>
                    <p>Tiempo: ${data.tiempo}</p>
                `;
            })
            .catch(error => console.error('Error:', error));
    }

    // Consultar mejor nadador por estilo
    function consultarMejorNadador(estilo) {
        fetch(`consultas.php?action=consultarMejorNadador&estilo=${estilo}`)
            .then(response => response.json())
            .then(data => {
                const resultadosDiv = document.getElementById('resultados');
                resultadosDiv.innerHTML = `
                    <div class="section-title">Mejor Nadador en ${estilo}</div>
                    <p>Nombre: ${data.nombre}</p>
                    <p>Distancia: ${data.distancia} metros</p>
                    <p>Tiempo: ${data.tiempo}</p>
                `;
            })
            .catch(error => console.error('Error:', error));
    }

    // Asignar eventos a los botones
    document.querySelector('button[onclick="asignarCarriles(5)"]').addEventListener('click', asignarCarriles);
    document.querySelector('button[onclick="consultarPrimerPuesto()"]').addEventListener('click', consultarPrimerPuesto);
    document.querySelector('button[onclick="resultadosPorEstilo(\'Crol\')"]').addEventListener('click', () => consultarMejorNadador('Crol'));
    document.querySelector('button[onclick="resultadosPorEstilo(\'Pecho\')"]').addEventListener('click', () => consultarMejorNadador('Pecho'));
    document.querySelector('button[onclick="resultadosPorEstilo(\'Espalda\')"]').addEventListener('click', () => consultarMejorNadador('Espalda'));
    document.querySelector('button[onclick="resultadosPorEstilo(\'Mariposa\')"]').addEventListener('click', () => consultarMejorNadador('Mariposa'));
});
