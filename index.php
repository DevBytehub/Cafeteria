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
    <title>Cafetería MZT</title>
    <link rel="icon" href="img/cafeteria.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
<header>
        <div class="header-container">
            <img src="img/cafeteria.png" alt="Logo" style="height: 64px; background-color: whitesmoke;">
            <h1>Cafetería MZT</h1>

            <a href="admin_login.html" class="admin-button">Admin</a>
        </div>
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

  
</body>
<footer>
        <p>&copy; 2024 Cafetería Moderna. Todos los derechos reservados.</p>
    </footer>
</html>
<?php
$conn->close();
?>