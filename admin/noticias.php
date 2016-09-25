<?php
	session_start();

	/* Comprobamos que esta página solo pueda ser accesible por un usuario con perfil administrador */
	if ($_SESSION['keyid'] != md5(session_id()) && $_SESSION['idusuario'] != md5(1) || $_SESSION['esadmin'] != md5('yes')){  
		session_destroy();
		
		header('Location: ../login.php');
	}
	
	require_once ($_SERVER['DOCUMENT_ROOT']. '/EjercicioFinal/models/Noticia.php');
	require_once ($_SERVER['DOCUMENT_ROOT']. '/EjercicioFinal/controllers/NoticiaController.php');
	
	/* Array para almacenar las noticias */
	$noticias = array();
	
	$noticiaController  = new NoticiaController();
	$noticias = $noticiaController->listarNoticiasAdmin();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ramón Bailén Sánchez">

    <title>La Liga</title>

    <!-- CSS -->
    <link href="../resources/css/bootstrap.min.css" rel="stylesheet">
    <link href="../resources/css/styles.css" rel="stylesheet">
    
    <!-- JS -->
	<script type="text/javascript" src="../resources/js/jquery1.12.3.js"></script>
	<script type="text/javascript" src="../resources/js/bootstrap.min.js"></script>
	
  </head>

  <body>
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">La Liga</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.php">Inicio</a></li>
               <li><a href="usuarios.php">Usuarios</a></li>
               <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Información<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="equipos.php">Equipos</a></li>
                  <li><a href="clasificacion.php">Clasificación</a></li>
                  <li><a href="partidos.php">Partidos</a></li>
                </ul>
              </li>
              <li><a href="noticias.php">Noticias</a></li>
            </ul>
            
            <form method="post" action="../controllers/LoginController.php">
	            <ul class="nav navbar-nav navbar-right">
	               <li> <a class="navbar-brand">¡Hola, <?php echo $_SESSION['nombreusuario']?>!</a></li>
	      		   	<li><button class="btn-link" type="submit" name="salir" id="salir"><span class="glyphicon glyphicon-log-in"></span>&nbspCerrar sesión</button></li>
	            </ul>
            </form>
          </div>
        </div>
      </nav>
      
       <div class="container">
    		<div class="row">
    			<h3>Gestión de Noticias</h3>
    		</div>
			<div class="row">
				<p><a href="crearNoticia.php" class="btn btn-success">Crear</a></p>
				<?php
					/* Si no hay noticias en el array */
					if($noticias == null) {
						echo("No se han insertado en BBDD noticias");
					}else{
				?>
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Fecha</th>
		                  <th>Imagen</th>
		                  <th>Titular</th>
		                  <th>Cuerpo</th>
		                  <th>Acción</th>
		                </tr>
		              </thead>
		              
		              <?php	
							/* Si hay noticias en el array */
							foreach($noticias as $noticia) {
						 ?>
		              <tbody>
		              	<tr>
		              	  <td class="dateTam">
		              	  <?php 
		              	  	$date = date_create($noticia->getFecha());
							echo date_format($date, 'd-m-Y');
		              	  ?>
		              	  </td>
						  <td><?php echo $noticia->getImagen()?></td>
						  <td><?php echo $noticia->getTitular()?></td>
						  <td><?php echo $noticia->getCuerpo()?></td>
						  <?php 
						  		echo '<td class="actionTam">';
							   	echo '<a class="btn btn-primary" href="verNoticia.php?id='.$noticia->getId().'">Ver</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-warning" href="editarNoticia.php?id='.$noticia->getId().'">Editar</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" name="borrar" href="../controllers/NoticiaController.php?action=borrar&id='.$noticia->getId().'">Borrar</a>';
							   	echo '</td>';
						  ?>
					   </tr>
					  <?php				
						 }
						}
					   ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>