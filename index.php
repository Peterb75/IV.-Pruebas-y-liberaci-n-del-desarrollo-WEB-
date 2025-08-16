<?php
if (isset($_GET['success'])) {
    echo '<p style="color: green;">' . htmlspecialchars($_GET['success']) . '</p>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador de Artículos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 600px; }
        label { display: block; margin-top: 10px; }
        input, textarea { width: 100%; padding: 8px; }
        #preview { display: flex; flex-wrap: wrap; }
        #preview img { max-width: 150px; margin: 5px; }
    </style>
</head>
<body>
    <h1>Crear Artículo</h1>
    <form id="formArticulo" action="procesar.php" method="POST" enctype="multipart/form-data">
        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" required>

        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="contenido" rows="10" required></textarea>

        <label for="imagenes">Imágenes (selecciona múltiples):</label>
        <input type="file" id="imagenes" name="imagenes[]" multiple accept="image/*">

        <div id="preview"></div>

        <button type="submit">Generar Artículo</button>
    </form>

    <p><a href="vista_articulos.php">Ver todos los artículos</a></p>

    <script>
        const inputImagenes = document.getElementById('imagenes');
        const preview = document.getElementById('preview');

        inputImagenes.addEventListener('change', () => {
            preview.innerHTML = ''; // Limpiar previsualización
            const files = inputImagenes.files;
            if (files.length > 0) {
                for (let file of files) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    preview.appendChild(img);
                }
            }
        });

        document.getElementById('formArticulo').addEventListener('submit', (e) => {
            const autor = document.getElementById('autor').value.trim();
            const contenido = document.getElementById('contenido').value.trim();
            if (!autor || !contenido) {
                alert('Debes llenar autor y contenido.');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>