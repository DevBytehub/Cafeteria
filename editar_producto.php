<?php
session_start();

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

$id = $_GET["id"];
$sql = "SELECT * FROM productos WHERE id=$id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    
    $imagen = $product['imagen'];
    if (!empty($_FILES["imagen"]["name"])) {
        $imagen = $_FILES["imagen"]["name"];
        move_uploaded_file($_FILES["imagen"]["tmp_name"], "uploads/" . $imagen);
    }
    
    $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', imagen='$imagen' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Producto agregado con éxito.";
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
    <title>Editar Producto</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="agregar_producto.css">

</head>
<body>
<header>
        <h1>Editar Producto</h1>
        <a href="admin_dashboard.php" class="admin-button">Regresar al Panel de Administración</a>
    </header>

    <main>
        <form action="editar_producto.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $product['nombre']; ?>" required>
            
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo $product['descripcion']; ?></textarea>
            
            <label for="precio">Precio:</label>
            <input type="number" step="0.01" id="precio" name="precio" value="<?php echo $product['precio']; ?>" required>
            
            <label for="imagen">Imagen del Producto:</label>
            <input type="file" id="imagen" name="imagen">
            <img src="uploads/<?php echo $product['imagen']; ?>" width="50">
            
            <button type="submit">Guardar Cambios</button>
        </form>
    </main>
</body>
</html>
