<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$host = ""; // Ajusta según tu configuración
$username = ""; // Usuario de la base de datos
$password = ""; // Contraseña del usuario de la base de datos
$dbname = ""; // Nombre de la base de datos

// Intentar conectar con la base de datos
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $passwd = $_POST['password'];

    // Consulta vulnerable a SQL Injection
    $sql = "SELECT * FROM usuario WHERE ID = '$id' AND password = '$passwd'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user_id'] = $id;
        header("Location: welcome.php");
        exit();
    } else {
        echo "<p style='color: red; font-weight: bold;'>Clave y/o contraseña inválidas.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            width: 300px;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .course-title {
            font-size: 16px;
            color: #F9B000; /* Amarillo específico */
	        font-weight: bold;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 2px solid #dcdcdc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background-color: #ed1c24; /* Rojo UTFSM */
            color: white;
            border: none;
            padding: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #d71118; /* Rojo Oscuro UTFSM */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="logo_usm.png" alt="Logo Universidad Técnica Federico Santa María">
        <div class="course-title">MTI-486 CIBERSEGURIDAD</div>
        <form method="post">
            ID: <input type="text" name="id"><br>
            Password: <input type="password" name="password"><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>