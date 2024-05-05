<?php
session_start();

// Redirigir si el usuario no está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$host = "";  // El host de la base de datos
$username = "";  // El nombre de usuario de la base de datos
$password = "";  // La contraseña de la base de datos
$dbname = "";  // El nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_SESSION['user_id'];  // Obtener el ID del usuario desde la sesión

// Consulta vulnerable a SQL Injection
$sql = "SELECT * FROM usuario WHERE ID = '$id'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            text-align: center;
            padding: 20px;
        }
        header {
            background-color: #ed1c24; /* Rojo UTFSM */
            color: #fff;
            padding: 10px 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        h1 {
            color: #ed1c24;
        }
        img {
            width: 200px;
            height: auto;
            margin-top: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #ffffff;
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <header>
        Universidad Tecnica Federico Santa Maria
    </header>
    <img src="logo_usm.png" alt="Logo Universidad Técnica Federico Santa María">
    <h1>Bienvenido</h1>
    <h2>Detalles del Usuario</h2>
    <ul>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<li>ID: " . htmlspecialchars($row['id']) . "</li>";
        echo "<li>Password: " . htmlspecialchars($row['password']) . "</li>"; // Considera NO mostrar contraseñas
    }
} else {
    echo "<li>Usuario no encontrado.</li>";
}
?>
    </ul>
    <?php
    // Cerrar conexión
    $conn->close();
    ?>
</body>
</html>