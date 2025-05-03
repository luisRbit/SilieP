<?php
$servername = "localhost";
$username = "root";
$password = "8227";
$dbname = "registro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
)";
$conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        // Redirige con bandera de éxito
        header("Location: " . $_SERVER['PHP_SELF'] . "?registro=exito");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();

// Solo mostramos el modal si ?registro=exito está en la URL
$mostrarModal = isset($_GET['registro']) && $_GET['registro'] === 'exito';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        url('comunity.jpg');
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

        .login-link {
            margin-top: 20px;
            text-align: center;
            color: #666;
        }

        .login-link a {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: var(--dark-green);
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="formu">
        <h1>Regístrate aquí</h1>
    </div>
    <div class="formulario">
        <form method="POST" action="">
            <label>Nombre:</label>
            <input type="text" name="Nombre" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Contraseña:</label>
            <input type="password" name="password" required>
            <button type="submit">Registrarse</button>
        </form>
    </div>
    <div class="login-link">
        <p>¿Ya tienes una cuenta? <a href="inicio.php">Inicia sesión aquí</a></p>
    </div>

    <!-- Modal de Registro Exitoso -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-success text-white">
          <div class="modal-header border-0">
            <h5 class="modal-title" id="registroModalLabel">Registro Exitoso!</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body text-center">
            Ya puede iniciar sesión en COOPNAZONAF <br>
            
        
          </div>
          <div class="modal-footer border-0 justify-content-center">
            <button type="button" class="btn btn-light text-success" data-bs-dismiss="modal">Aceptar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php if ($mostrarModal): ?>
    <script>
      window.addEventListener('DOMContentLoaded', () => {
        const modal = new bootstrap.Modal(document.getElementById('registroModal'));
        modal.show();
      });
    </script>
    <?php endif; ?>

</body>
</html>
