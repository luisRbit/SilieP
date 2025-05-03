<?php
$conexion = new mysqli("localhost", "root", "8227", "ana");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$mensajeExito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $mensaje = $_POST["mensaje"];

    $sql = "INSERT INTO coopnazonaf_formulario (nombre, correo, mensaje) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $nombre, $correo, $mensaje);

    if ($stmt->execute()) {
        $mensajeExito = "Formulario enviado correctamente.";
    } else {
        $mensajeExito = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Coopnazonaf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', Arial, sans-serif;
            position: relative;
            
            margin: auto;
            
        }
        .form-container {
            max-width: 600px;
            margin: 50px;
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            left: 800px;
        
        }
        .form-container::before {
            content: '';
            position: absolute;
            left: -700px;
            top: 50%;
            transform: translateY(-50%);
            width: 600px;
            height: 300px;
            background: url("https://www.coopnazonaf.com/images/logonuevo2.png") no-repeat center center;
            background-size: contain;
            opacity: 0.9;
        }
        .titulo {
            color: #28a745;
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: 600;
            text-align: center;
        }
        .form-label {
            color: #495057;
            font-weight: 500;
            margin-bottom: 8px;
        }
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
        }
        .btn-green {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-green:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
        }
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 25px;
        }
        textarea.form-control {
            min-height: 120px;
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

<div class="form-container">
    <h2 class="text-center titulo">Formulario de admición</h2>
    <?php if ($mensajeExito): ?>
        <div class="alert alert-success mt-3">
            <?= $mensajeExito ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nombre" class="form-label">Diganos su nombe completo</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">cual es su Correo electrónico?</label>
            <input type="email" class="form-control" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="mensaje" class="form-label">Diganos porque tenemos que admitirlo en nuestra cooperativa</label>
            <textarea class="form-control" name="mensaje" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-green w-100">Enviar</button>
    </form>
    <div class="login-link">
        <p><a href="index.html">Home</a></p>
    </div>

</div>

</body>
</html>
