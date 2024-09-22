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

$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/cafeteria.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Cafetería Moderna</title>
    <link rel="stylesheet" href="admin_styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <header>
            <h1 style="text-align: center;">Panel de Administración</h1>
            <nav>
                <a href="logout.php" class="logout-button btn">Cerrar sesión</a>
            </nav>
        </header>


        <main>
        <h2>Bienvenido, <?php echo $_SESSION['admin']; ?></h2>
        <a href="agregar_producto.php" class="btn-primary btn">Agregar Producto</a>

        <h3>Lista de Productos</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . $row["descripcion"] . "</td>";
                    echo "<td>" . $row["precio"] . "</td>";
                    echo "<td><img src='uploads/" . $row["imagen"] . "' width='64'></td>";
                    echo "<td>
                            <a class='btn-editar btn' href='editar_producto.php?id=" . $row["id"] . "'>Editar</a><a class='btn-eliminar btn' href='eliminar_producto.php?id=" . $row["id"] . "'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay productos.</td></tr>";
            }
            ?>
        </table>
    </main>

        <footer>
            <p>&copy; 2024 Cafetería Moderna. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>
</html>
