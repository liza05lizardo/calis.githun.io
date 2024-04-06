<?php
include('conexion.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['Guardar'])) {
    $imagen = $_FILES['imagen']['name'];
    $nombre = $_POST['titulo'];
    
    $carpeta = 'imagenes/';
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    if (isset($imagen) && $imagen != "") {
        // Obtener el nombre del archivo subido
        $nombre_archivo = $_FILES['imagen']['name'];

        // Generar un nombre único para el archivo
        $nuevo_nombre = 'imagen_' . uniqid() . '_' . $nombre_archivo;

        // Mover el archivo a la carpeta de destino con el nuevo nombre
        $ruta_destino = $carpeta . $nuevo_nombre;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino);

        // Insertar datos en la base de datos
        $query = "INSERT INTO imagenes(imagen, nombre) VALUES ('$nuevo_nombre', '$nombre')";
        $resultado = mysqli_query($conn, $query);

        if($resultado){
            $_SESSION['mensaje'] = 'Se ha subido correctamente';
            $_SESSION['tipo'] = 'success';
            header('location:../proyecto.php');
            header('location:../proyecto_cliente.php');
            exit;
        } else {
            $_SESSION['mensaje'] = 'Ocurrió un error al insertar en la base de datos';
            $_SESSION['tipo'] = 'danger';
            header('location:../proyecto.php');
            header('location:../proyec_cliente.php');
            exit;
        }
    }
} 
?>