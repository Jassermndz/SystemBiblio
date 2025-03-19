document.addEventListener('DOMContentLoaded', function () {
    const categoriaSelect = document.getElementById('categoria');
    const librosContainer = document.getElementById('libros-container');

    function cargarLibros(categoriaId = null) {
        let url = '../Consultas/cargarlibros.php';

        if (categoriaId !== null && categoriaId !== 0) {
            url += `?categoria_id=${categoriaId}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.libros.length === 0) {
                    librosContainer.innerHTML = '<p>No hay libros disponibles para esta categoría.</p>';
                } else {
                    librosContainer.innerHTML = ''; 
                    data.libros.forEach(libro => {
                        const card = document.createElement('div');
                        card.classList.add('col-md-4', 'mb-4');
                        const imagenSrc = libro.imagen ? `../${libro.imagen}` : 'default-image.jpg';

                        card.innerHTML = `
                            <div class="card">
                                <img src="${imagenSrc}" class="card-img-top" alt="${libro.titulo}">
                                <div class="card-body">
                                    <h5 class="card-title">${libro.titulo}</h5>
                                    <p class="card-text"><strong>Autor:</strong> ${libro.autor}</p>
                                    <p class="card-text"><strong>Editorial:</strong> ${libro.editorial}</p>
                                    <p class="card-text"><strong>Cantidad disponible:</strong> ${libro.cantidad_disponible}</p>
                                    <p class="card-text"><strong>Año de publicación:</strong> ${libro.anio_publicacion}</p>
                                    <p class="card-text"><strong>Categoría:</strong> ${libro.categoria_nombre}</p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#prestamoModal" onclick="abrirModal(${libro.id}, '${libro.titulo}')">Registrar Préstamo</button>
                                </div>
                            </div>
                        `;
                        librosContainer.appendChild(card);
                    });
                }

                if (data.categorias) {
                    categoriaSelect.innerHTML = '<option value="0">Todas</option>';
                    data.categorias.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id;
                        option.textContent = categoria.nombre;
                        categoriaSelect.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error al cargar los libros:', error));
    }

    cargarLibros();

    categoriaSelect.addEventListener('change', function () {
        const categoriaId = parseInt(categoriaSelect.value); 
        cargarLibros(categoriaId === 0 ? null : categoriaId); 
    });
});
