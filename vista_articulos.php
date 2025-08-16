<?php
$json_file = 'articulos/articulos.json';
$articulos = file_exists($json_file) ? json_decode(file_get_contents($json_file), true) : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Todos los Artículos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Todos los Artículos</h1>
    <p><a href="index.php">Crear nuevo artículo</a></p>

    <?php if (empty($articulos)): ?>
        <p>No hay artículos creados aún.</p>
    <?php else: ?>
        <?php foreach ($articulos as $articulo): ?>
            <div class="articulo">
                <h2>Artículo: <?php echo htmlspecialchars(substr($articulo['contenido'], 0, 20)); ?></h2>
                <p class="autor">Autor: <?php echo htmlspecialchars($articulo['autor']); ?></p>
                <p>Fecha: <?php echo htmlspecialchars($articulo['fecha']); ?></p>
                <div class="contenido"><?php echo htmlspecialchars($articulo['contenido']); ?></div>
                <h3>Imágenes</h3>
                <?php foreach ($articulo['imagenes'] as $img): ?>
                    <img src="<?php echo htmlspecialchars($img); ?>" alt="Imagen adjunta" class="ImagenMostrar">
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>