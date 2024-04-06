<?php
include('backend/conexion.php');

// Borrar imagen si se envió el ID
if(isset($_POST['borrar'])) {
    $imagen = $_POST['borrar'];
    $ruta_imagen = 'Backend/imagenes/' . $imagen;
    
    // Eliminar la imagen del sistema de archivos
    if(file_exists($ruta_imagen)) {
        unlink($ruta_imagen);
    }

    // Eliminar la entrada de la imagen de la base de datos
    $query_delete = "DELETE FROM imagenes WHERE imagen = '$imagen'";
    $resultado_delete = mysqli_query($conn, $query_delete);
    if($resultado_delete) {
        $_SESSION['mensaje'] = 'Imagen eliminada correctamente';
        $_SESSION['tipo'] = 'success';
    } else {
        $_SESSION['mensaje'] = 'Error al eliminar la imagen';
        $_SESSION['tipo'] = 'danger';
    }
    header('Location: proyecto.php');
    exit;
}

$query = "SELECT * FROM imagenes";
$resultado = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creaciones Satín</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css"> <!-- Enlace al archivo CSS -->
   
</head>
<body>
<header class="header">
       
       <div class="imagen">
           <img src="img/logo.png" alt="">
       </div>
    
       <nav>
           <a href="login.html">Iniciar Sesión</a>
           <a href="proyecto.php">Registro de imagen</a>
       </nav>
   </header>
  <div class="container">
    <div class="row">
       <div class="col-lg-4">
         <h1 class="text-primary">Subir imagen</h1>
         <form action="Backend/subir.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
              <label for="my-input">Seleccione una Imagen</label>
              <input id="my-input"  type="file" name="imagen">
          </div>
          <div class="form-group">
              <label for="my-input">Titulo de la Imagen</label>
              <input id="my-input" class="form-control" type="text" name="titulo">
          </div>
          <?php if(isset($_SESSION['mensaje'])){ ?>
          <div class="alert alert-<?php echo $_SESSION['tipo'] ?> alert-dismissible fade show" role="alert">
         <strong><?php echo $_SESSION['mensaje']; ?></strong> 
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
     </button>
       </div>
          <?php session_unset(); } ?>
          <input type="submit" value="Guardar" class="btn btn-primary" name="Guardar">
         </form>
       </div>
       <div class="col-lg-8">
           <h1 class="text-primary text-center">Galeria de Imagenes</h1>
           <hr>
           <div class="card-columns">
               <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
                   <div class="card">
                       <a href="Backend/imagenes/<?php echo $row['imagen']; ?>" download>
                           <img src="icono2.jpg" class="img-descarga" alt="Icono de descarga">
                       </a>
                       <div class="card-body">
                           <h5 class="card-title"><strong><?php echo $row['nombre']; ?></strong></h5>
                           <form action="proyecto.php" method="post">
                               <button type="submit" name="borrar" value="<?php echo $row['imagen']; ?>" class="btn btn-danger">Eliminar</button>
                           </form>
                       </div>
                   </div>
               <?php } ?>
           </div>
       </div>
    </div>
  </div>
  <!-- Scripts necesarios -->
   <script src="/js/jquery.min.js"></script>
   <script src="/js/convert.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>