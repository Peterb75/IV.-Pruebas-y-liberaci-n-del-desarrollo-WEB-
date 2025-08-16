<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$autor = trim($_POST['autor'] ?? '');
$contenido = trim($_POST['contenido'] ?? '');
$imagenes = $_FILES['imagenes'] ?? [];

if (empty($autor) || empty($contenido)) {
    die('Error: Debes llenar autor y contenido.');
}

// Generar slug
$titulo_aprox = substr($contenido, 0, 20);
$slug = preg_replace('/\s+/', '_', strtolower(trim(empty($titulo_aprox) ? date('Ymd_His') : $titulo_aprox)));

// Crear directorios
$base_dir = 'articulos';
$img_dir = "$base_dir/imagenes/$slug";

if (!is_dir($base_dir)) mkdir($base_dir, 0755, true);
if (!is_dir($img_dir)) mkdir($img_dir, 0755, true);

// Procesar imágenes
$img_paths = [];
if (!empty($imagenes['name'][0])) {
    foreach ($imagenes['name'] as $key => $name) {
        if ($imagenes['error'][$key] === 0 && strpos($imagenes['type'][$key], 'image/') === 0) {
            $dest = "$img_dir/" . basename($name);
            move_uploaded_file($imagenes['tmp_name'][$key], $dest);
            $img_paths[] = "articulos/imagenes/$slug/" . basename($name);
        }
    }
}

// Cargar o inicializar articulos.json
$json_file = "$base_dir/articulos.json";
$articulos = file_exists($json_file) ? json_decode(file_get_contents($json_file), true) : [];

// Agregar nuevo artículo
$articulos[] = [
    'slug' => $slug,
    'autor' => $autor,
    'contenido' => $contenido,
    'imagenes' => $img_paths,
    'fecha' => date('Y-m-d H:i:s')
];

// Guardar en JSON
file_put_contents($json_file, json_encode($articulos, JSON_PRETTY_PRINT));

// Redirigir a index.php con mensaje de éxito
header('Location: index.php?success=' . urlencode("Artículo generado correctamente"));
exit;
?>