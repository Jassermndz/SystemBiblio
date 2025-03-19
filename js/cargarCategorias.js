window.onload = function() {
    fetch('../Consultas/categorias.php')
    .then(response => response.text())
    .then(data => {
        let tempContainer = document.createElement('div');
        tempContainer.innerHTML = `<table>${data}</table>`;
        
        let select = document.getElementById('categoria');
        select.innerHTML = '<option value="">Seleccione una categoría</option>'; 

        let rows = tempContainer.querySelectorAll('tr');
        rows.forEach(row => {
            let cells = row.querySelectorAll('td');
            if (cells.length === 2) {
                let id = cells[0].textContent.trim();
                let nombre = cells[1].textContent.trim();
                let option = document.createElement('option');
                option.value = id;
                option.textContent = nombre;
                select.appendChild(option);
            }
        });
        select.addEventListener('change', function() {
            let selectedOption = select.options[select.selectedIndex];
            let categoriaNombre = selectedOption.textContent.trim();
            document.getElementById('categoria_nombre').value = categoriaNombre;
        });
    })
    .catch(error => {
        console.error('Error al cargar categorías:', error);
    });
};


