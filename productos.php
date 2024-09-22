<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_cms";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si hay errores de conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener todos los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="img/cafeteria.png" type="image/x-icon">
</head>
<body>
    <header>
        <h1>Nuestros Productos</h1>
        <nav>
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="productos.php">Productos</a></li>
                <!-- <li><a href="pedidos.html">Pedidos</a></li> -->
                <li><a href="admin_login.html">Admin</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="productos-grid">
            <?php
            if ($result->num_rows > 0) {
                // Recorrer los productos y mostrarlos
                while($row = $result->fetch_assoc()) {
                    echo "<div class='producto'>";
                    echo "<img src='uploads/" . $row["imagen"] . "' alt='" . $row["nombre"] . "' class='producto-imagen'>";
                    echo "<h2>" . $row["nombre"] . "</h2>";
                    echo "<p>" . $row["descripcion"] . "</p>";
                    echo "<p class='precio'>$" . $row["precio"] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay productos disponibles en este momento.</p>";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Cafetería</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
