<?php
// Incluye el archivo de conexión
include('Backend/conexion.php');

try {
    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $gmail = $_POST['gmail'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Verificar si las contraseñas coinciden
        if ($password != $confirm_password) {
            echo "Las contraseñas no coinciden.";
        } else {
            // Hash de la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Preparar la consulta SQL
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, gmail, password) VALUES (?, ?, ?)");

            // Bind de parámetros
            $stmt->bind_param('sss', $nombre, $gmail, $hashed_password);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Si el registro fue exitoso, muestra la alerta
                echo "<script>Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: '¡Registro exitoso!',
                  showConfirmButton: false,
                  timer: 1500
                });</script>";
            } else {
                echo "Error al registrar el usuario.";
            }
        }
    }
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Cierra la conexión
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Registro de cliente</title>
<link rel="stylesheet" href="css/styles_login.css">
</head>
<body>
<div class="login-box">
  <h2>Registro</h2>
  <form id="registro-form" action="registro_usuario.php" method="post">
    <div class="user-box">
      <input type="text" name="nombre" required="">
      <label>Nombre</label>
    </div>
    <div class="user-box">
      <input type="text" name="gmail" required="">
      <label>Gmail</label>
    </div>
    <div class="user-box">
      <input type="password" name="password" required="">
      <label>Password</label>
    </div>
    <div class="user-box">
      <input type="password" name="confirm_password" required="">
      <label>Confirm Password</label>
    </div>
    <a href="#" id="registro-button">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Registrar   
    </a>
    <button type="submit" style="display: none;">Registrar</button>
    <a href="login.html">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Iniciar
    </a>
    <button type="submit" style="display: none;">Iniciar</button>
  </form>
 
</div>

<script>
document.getElementById("registro-button").addEventListener("click", function(event) {
  event.preventDefault(); // Evita que se realice el comportamiento por defecto del enlace

  // Envía el formulario
  document.getElementById("registro-form").submit();
});
</script>

</body>
</html>