<?php
$servername = "localhost";
$username = "root";
$password = "8227";
$dbname = "registro";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        
        // In the PHP section, update the header location
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user"] = $email;
            header("Location: index.html");
            exit();
        } else {
            echo "<script>alert('¡Contraseña incorrecta!');</script>";
        }
        
        // In the HTML section, update the button
        
    } else {
        echo "<script>alert('¡Email incorrecto!');</script>";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión</title>
</head>

<style>
:root {
    --primary-green: #28a745;
    --dark-green: #1e7e34;
    --light-green: #e8f5e9;
}

body {
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)),
                url('comunity.jpg ');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

.formu {
    background-color: var(--primary-green);
    padding: 20px 40px;
    border-radius: 10px 10px 0 0;
    margin-bottom: -10px;
}

.formu h1 {
    color: white;
    margin: 0;
    font-size: 24px;
}

.formulario {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    width: 320px;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 500;
}

input {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    box-sizing: border-box;
    border: 2px solid #e0e0e0;
    border-radius: 5px;
    transition: all 0.3s ease;
}

input:focus {
    border-color: var(--primary-green);
    outline: none;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.2);
}

button {
    width: 100%;
    padding: 12px;
    background-color: var(--primary-green);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s ease;
}

button:hover {
    background-color: var(--dark-green);
    transform: translateY(-1px);
}

.paputo {
    margin-top: 20px;
    text-align: center;
    color: #666;
}

.tinki a {
    color: var(--primary-green);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.tinki a:hover {
    color: var(--dark-green);
    text-decoration: underline;
}
</style>

<body background-color="" >
   <div class="formu"> <h1>Inicio de Sesión</h1></div>
    <div class="formulario">
        <form method="POST" action="">
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit" href="index.html">Iniciar Sesión</button>
    </form>
    </div>
    <div class="paputo"><p>¿No tienes una cuenta? <div class="tinki"><a href="registro.php">Regístrate aquí</a></div></p></div>
</body>
</html>

