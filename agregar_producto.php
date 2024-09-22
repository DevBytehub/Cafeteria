<?php
session_start();

// Verificar si el administrador ha iniciado sesión
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html");
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_cms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejar la solicitud de agregar un nuevo producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $imagen = $_FILES["imagen"]["name"];
    
    // Mover la imagen al directorio de imágenes
    move_uploaded_file($_FILES["imagen"]["tmp_name"], "uploads/" . $imagen);
    
    $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES ('$nombre', '$descripcion', '$precio', '$imagen')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Producto agregado con éxito.";
        echo "<script>alert('Producto agregado con éxito.');</script>";
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link rel="icon" href="img/cafeteria.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="agregar_producto.css">

</head>
<body>
    <header>
        <h1>Agregar Nuevo Producto</h1>
        <a href="admin_dashboard.php" class="admin-button">Regresar al Panel de Administración</a>
    </header>

    <main>
        <form action="agregar_producto.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" required>
            
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>
            
            <label for="precio">Precio:</label>
            <input type="number" step="0.01" id="precio" name="precio" required>
            
            <label for="imagen">Imagen del Producto:</label>
            <input type="file" id="imagen" name="imagen" required>
            
            <button type="submit">Agregar Producto</button>
        </form>
    </main>
</body>
</html>
