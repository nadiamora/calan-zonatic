<?php

	include_once 'database.php';
	
	session_start();

    if(isset($_GET['cerrar'])){
        session_unset(); 

        // destroy the session 
        session_destroy(); 
    }
    
    if(isset($_SESSION['idUsuario'])){
        switch($_SESSION['idUsuario']){
            case 1:
                header('location: usuarios/nosotros.php');
            break;

            case 2:
                header('location: administrador/solicitudes.php');
            break;

            default:
        }
    }

    if(isset($_POST['numControl']) && isset($_POST['contrasena'])){
        $numControl = $_POST['numControl'];
        $contrasena = $_POST['contrasena'];

        $db = new Database();
        $query = $db->connect()->prepare('SELECT  *FROM usuario WHERE numControl = :numControl AND contrasena = :contrasena');
        $query->execute(['numControl' => $numControl, 'contrasena' => $contrasena]);

        $row = $query->fetch(PDO::FETCH_NUM);
        
        if($row == true){
            $idUsuario = $row[1];
            
            $_SESSION['idUsuario'] = $idUsuario;
            switch($idUsuario){
                case 1:
                    header('location: usurios/misarticulo.php');
                break;

                case 2:
                header('location: administrador/solicitudes.php');
                break;

                default:
            }
        }else{
            // no existe el usuario
             $errorLogin = "Nombre de usuario o contraseña incorrecto";

             include_once 'index.php';
        }
        

    }	
?>

<?php
/*Requerir conexion con la BD*/
   $servidor = "localhost";
   $nombreusuario = "root";
   $password = "";
   $db = "zona_tic";
   
   $conexion = new mysqli($servidor, $nombreusuario, $password, $db);

   if($conexion->connect_error){
     die("Conexion fallida: " . $conexion->connect_error);
   }

  $message = '';

  if (isset($_POST['numControl']) && isset($_POST['idUsuario']) && isset($_POST['correo']) && isset($_POST['nombre']) && isset($_POST['apellidoPat']) && isset($_POST['apellidoMat']) && isset($_POST['contrasena'])){
	/*Vincular parametros*/
	$numControl = $_POST ['numControl'];	
	$idUsuario = $_POST ['idUsuario'];
	$correo = $_POST ['correo'];
	$nombre = $_POST ['nombre'];
	$apellidoPat = $_POST ['apellidoPat'];
	$apellidoMat = $_POST ['apellidoMat'];
	$contrasena = $_POST ['contrasena'];	
    
    /*Agregar datos a la BD*/
    $sql = "INSERT INTO usuario (numControl, idUsuario, correo, nombre, apellidoPat, apellidoMat, contrasena) VALUES ('$numControl', '$idUsuario', '$correo', '$nombre', '$apellidoPat', '$apellidoMat', '$contrasena')"; 
    
    /*Ejecutar consulta para evitar usuarios repetidos*/

    $verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuario WHERE numControl = '$numControl'");
    if (mysqli_num_rows($verificar_usuario) > 0) {
      $verificar_usuario = "El usuario ingresado ya esta registrado";

      include_once 'index.php';
    }


    


  if ($conexion->query($sql) === true){
    $message = 'Tu usuario ha sido creado exitosamente';
} else{
    die ("Lo sentimos ha ocurrido un error al intentar registrarlo: " . $conexion->error);
}
$conexion->close();

}
?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">




    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <title>Zona Tic Inicio</title>



</head>
<body background="img/fondo7.png">
	<section class="container">

		<!--Inicio de barra de navegación-->
	<div class="row margen">
			<div class="col-md-2 header">
				<img src="img/logon.png" class="img" />
			</div>
			<div class="col-md-10 header">
				<!--Navegación-->
				<div class="container-fluid">
					<header>
						<nav class="navbar navbar-expand-lg navbar-light">
							<a class="navbar-brand" href="index.html"><img src=""></a>
							<button class="navbar-toggler" type="button"
								data-toggle="collapse" data-target="#navbarSupportedContent"
								aria-controls="navbarSupportedContent" aria-expanded="false"
								aria-label="Toggle navigation">
								<span class="navbar-toggler-icon"></span>
							</button>
	
							<div class="collapse navbar-collapse" id="navbarSupportedContent">
								<ul class="navbar-nav mr-auto">
									<li class="nav-item active"><a class="nav-link"
										href="/zonatic">Inicio <span class="sr-only">(current)</span></a>
									</li>
									<li class="nav-item"><a class="nav-link"
										href="quienessomos">Quienes Somos</a></li>
									<li class="nav-item">
								</ul>
								<!-- Button trigger modal -->
								<div class="dropdown">
									<button style="margin-left:;" type="button"
										class="btn btn-primary" data-toggle="modal"
										data-target="#exampleModal">Iniciar Sesión</button>
								</div>
	
								<!-- Inicio de Sesión Pop Up -->
								<div class="modal fade" id="exampleModal" tabindex="-1"
									role="dialog" aria-labelledby="exampleModalLabel"
									aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Iniciar
													Sesión</h5>
												<button type="button" class="close" data-dismiss="modal"
													aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
	
												<form id="formLogin"  action="#" method="POST">
													<?php
													if(isset($errorLogin)){
														echo $errorLogin;
													}
													?>
												<div>
													<input type="text" name="numControl" id="numControl" class="form-control" placeholder="Número de control"/>
												</div><br>

												<div>
													<input type="password" name="contrasena" class="form-control" id="contrasena" placeholder="Contraseña"/>
												</div>	<br>
												<div>
													<input type="submit" class="btn btn-primary"  value="Iniciar Sesión" >
												</div>
												</form>
	
	
	
												<a class="nav-link" href="recuperar">Recuperar
													contraseña</a>
	
											</div>
											<div class="registro-footer"></div>
										</div>
									</div>
								</div>
								</li>
	
								<button style="margin-left:" type="button"
									class="btn btn-primary" data-toggle="modal"
									data-target="#exampleModalCenter">Registrarse</button>
	
								<!-- Registrar -->
								<div class="modal fade" id="exampleModalCenter" tabindex="-1"
									role="dialog" aria-labelledby="exampleModalCenterTitle"
									aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalCenterTitle">Registrarse</h5>
												<button type="button" class="close" data-dismiss="modal"
													aria-label="Envíar">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
	
												<form action="index.php" method="POST">

												 <?php if(isset($verificar_usuario)){
													echo $verificar_usuario;
												 }

												  ?>
															<div class="form-group">
																<label for="correo">E-mail</label> 
																<input type="email" class="form-control" name="correo" id="correo" placeholder="nombre@ejemplo.com">
															</div>
															<div class="form-group row">
																<label for="contrasenaRegistrar" class="col-sm-2 col-form-label">Contraseña</label>
																<div class="col-sm-10">
																	<input type="password" class="form-control" name="contrasena" id="contrasenaRegistrar" placeholder="">
																</div>
															</div>
															<div class="form-group row">
																<label for="recontrasena" class="col-sm-2 col-form-label">Confirmar
																	contraseña</label>
																<div class="col-sm-10">
																	<input type="password" class="form-control" name="confirmarContrasena" id="recontrasena" placeholder="">
																</div>
															</div>
															<div class="form-group">
																<label for="nombre">Nombre Usuario</label> 
																<input type="text" class="form-control" name="nombre" id="nombre" placeholder="">
															</div>
															<div class="form-group">
																<label for="apellidoPat">Apellido Paterno</label>
																<input type="text" class="form-control" name="apellidoPat" id="apellidoPat" placeholder="">
															</div>
															<div class="form-group">
																<label for="apellidoMat">Apellido Materno</label>
																<input type="text" class="form-control" name="apellidoMat" id="apellidoMat" placeholder="">
															</div>
															<div class="form-group">
																<label for="numControlRegistrar">Número de
																	control</label> <input type="text" class="form-control" name="numControl" id="numControlRegistrar"
																	placeholder="">
															</div>
															<p>Escoja algún tipo de usuario</p>
															<select class="form-control" name="idUsuario" id="idUsuario">
										
																<option value="1"> Usuario</option>
																<option value="2">Revisor contenido</option>
																<option value="3">Revisor estilo</option>
																<option value="4">Administrador</option>
															</select>
														</div>
															<input type="submit" class="btn btn-primary"  value="Registrar">
	
												</form>
												
										</div>
									</div>
								</div>
								</ul>
							</div>
						</nav>
	
	
					</header>
	
				</div>
			</div>
		</div>
		<!--Fin de barra de navegación-->

		<!--Inicio del carrusel-->
<!--Header 2-->
	<div class="row">
			<div class="col-md header2">
				<h1 class="entrada">Bienvenido a ZonaTIC</h1>
				<p class="lead">
					<b> <marquee behavior=alternate>Dale un vistazo a los
							artículos más relevantes del momento</marquee>
					</b>
				</p>
	
			</div>
	
		</div>
	
	
		<!--carrusel-->
		<div class="row margen">
			<div class="col-md carro">
				<div class="bd-example">
					<div id="carouselExampleCaptions" class="carousel slide"
						data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#carouselExampleCaptions" data-slide-to="0"
								class="active"></li>
							<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
							<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
						</ol>
						<div class="carousel-inner">
							<div class="carousel-item active">
								<img src="img/ejemplo.jpg" class="d-block w-100"
									alt="Artículo no Encontrado"/>
								<div class="carousel-caption d-none d-md-block">
									<div class="textodecarrucel"></div>
								</div>
							</div>
							<div class="carousel-item">
								<img src="img/ejemplo2.png" class="d-block w-100"
									alt="Artículo no Encontrado"/>
								<div class="carousel-caption d-none d-md-block">
									<div class="textodecarrucel">
										<h4>Segundo artículo más visto</h4>
										<h4></h4>
									</div>
								</div>
							</div>
							<div class="carousel-item">
								 <img src="img/utng.jpg" class="d-block w-100"
									alt="Artículo no Encontrado"/>
								<div class="carousel-caption d-none d-md-block">
	
	
									<h4>Tercer artículo más visto</h4>
									<h4>Praesent commodo cursus magna, vel scelerisque nisl
										consectetur.</h4>
	
								</div>
							</div>
						</div>
						<a class="carousel-control-prev" href="#carouselExampleCaptions"
							role="button" data-slide="prev"> <span
							class="carousel-control-prev-icon" aria-hidden="true"></span> <span
							class="sr-only">Previous</span>
						</a> <a class="carousel-control-next" href="#carouselExampleCaptions"
							role="button" data-slide="next"> <span
							class="carousel-control-next-icon" aria-hidden="true"></span> <span
							class="sr-only">Next</span>
						</a>
					</div>
				</div>
	
			</div>
	
		</div>
		<!--Fin del carrusel-->

		<!-- Solo el Body -->

		<div class="row">
			<div class="col-md-4"></div>

		</div>
		<div class="row header8">
			<div class="col-md-4 header8">
				<div class="listaarticulos">
					<h2>Artículos Generales</h2>
				</div>

			</div>
			<div class="col-md-4 header8">
				<nav class="navbar navbar-expand-lg"
					style="background-color: #e3f2fd";>


					<li class="nav-item dropdown"><a
						class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
						role="button" data-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false"> Categorías </a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item "
								href="conocimientosgenerales">Conocimientos
								generales TI</a> <a class="dropdown-item "
								href="conocimentosespecializados">Conocimientos
								especializados</a> <a class="dropdown-item "
								href="tialavanguardia">TI a la vanguardia</a> <a
								class="dropdown-item "
								href="noticiasyeventos">Noticias y
								eventos TIC</a>
						</div></li>

					</ul>

				</nav>
			</div>

			<div class="col-md-4 header8">
				<nav class="navbar navbar-light1" style="background-color: #e3f2fd";>
					</ul>
					<form class="my-1 my-lg-0">
						<input class=" mr-sm-1" type="search" placeholder="Artículos"
							aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
					</form>
				</nav>

			</div>

		</div>



		<!--Contenido-->
		<div class="row margen">

			<!--Articulos-->
			<div class="col-md-6 articulo">
				<div class="row margen">
					<div class="col-md-11 subar">
						<div class="card1" style="width: auto; height: auto;">
							<img src="${pageContext.request.contextPath}/resources/img/ejemplo.jpg" width="auto" height="170"
								class="card-img-top" alt="No se pudo Encontrar el Artículo"/>
							<div class="card-body">
								<h5 class="card-title">Artículo</h5>
								<p class="card-text">Aquí va un resumen breve del artículo.</p>
								<ul class="navbar-nav mr-auto">
									<li class="nav-item active"><a class="nav-link"
										href="articulo"><button
												class="enlacearticulo" type="submit">Ir a</button></a></li>
								</ul>
							</div>
						</div>
					</div>

				</div>
				<div class="row margen">
					<div class="col-md-11 subar">
						<div class="card1" style="width: auto; height: auto;">
							<img src="${pageContext.request.contextPath}/resources/img/ejemplo9.jpg" width="auto"
								height="170" class="card-img-top"
								alt="No se pudo Encontrar el Artículo">
							<div class="card-body">
								<h5 class="card-title">Artículo</h5>
								<p class="card-text">Aquí va un resumen breve del artículo.</p>
								<ul class="navbar-nav mr-auto">
									<li class="nav-item active"><a class="nav-link"
										href="articulo"><button
												class="enlacearticulo" type="submit">Ir a</button></a></li>
								</ul>
							</div>
						</div>
					</div>

				</div>
				<div class="row margen">
					<div class="col-md-11 subar">
						<div class="card1" style="width: auto; height: auto;">
							<img src="${pageContext.request.contextPath}/resources/img/ejemplo4.jpg" width="auto"
								height="170" class="card-img-top"
								alt="No se pudo Encontrar el Artículo"/>
							<div class="card-body">
								<h5 class="card-title">Artículo</h5>
								<p class="card-text">Aquí va un resumen breve del artículo.</p>
								<ul class="navbar-nav mr-auto">
									<li class="nav-item active"><a class="nav-link"
										href="articulo"><button
												class="enlacearticulo" type="submit">Ir a</button></a></li>
								</ul>
							</div>
						</div>
					</div>

				</div>

			</div>

			<div class="col-md-6 articulo">
				<div class="row margen">
					<div class="col-md-11 subar">
						<div class="card1" style="width: auto; height: auto;">
							<img src="${pageContext.request.contextPath}/resources/img/ejemplo5.jpg" width="auto"
								height="170" class="card-img-top"
								alt="No se pudo Encontrar el Artículo">
							<div class="card-body">
								<h5 class="card-title">Artículo</h5>
								<p class="card-text">Aquí va un resumen breve del artículo.</p>
								<ul class="navbar-nav mr-auto">
									<li class="nav-item active"><a class="nav-link"
										href="articulo"><button
												class="enlacearticulo" type="submit">Ir a</button></a></li>
								</ul>
							</div>
						</div>
					</div>

				</div>
				<div class="row margen">
					<div class="col-md-11 subar">
						<div class="card1" style="width: auto; height: auto;">
							<img src="${pageContext.request.contextPath}/resources/img/ejemplo6.jpg" width="auto"
								height="170" class="card-img-top"
								alt="No se pudo Encontrar el Artículo"/>
							<div class="card-body">
								<h5 class="card-title">Artículo</h5>
								<p class="card-text">Aquí va un resumen breve del artículo.</p>
								<ul class="navbar-nav mr-auto">
									<li class="nav-item active"><a class="nav-link"
										href="articulo"><button
												class="enlacearticulo" type="submit">Ir a</button></a></li>
								</ul>
							</div>
						</div>
					</div>

				</div>
				<div class="row margen">
					<div class="col-md-11 subar">
						<div class="card1" style="width: auto; height: auto;">
							<img src="${pageContext.request.contextPath}/resources/img/ejemplo7.jpg" width="auto"
								height="170" class="card-img-top"
								alt="No se pudo Encontrar el Artículo"/>
							<div class="card-body">
								<h5 class="card-title">Artículo</h5>
								<p class="card-text">Aquí va un resumen breve del artículo.</p>

								<ul class="navbar-nav mr-auto">
									<li class="nav-item active"><a class="nav-link"
										href="articulo"><button
												class="enlacearticulo" type="submit">Ir a</button></a></li>
								</ul>

							</div>
						</div>
					</div>

				</div>
			</div>

			<nav class="mas">
				<div class="col-md-4"></div>
				<ul class="pagination">
					<li class="page-item"><a class="page-link" href="#"
						tabindex="-1" aria-disabled="true">Anterior</a></li>
					<li class="page-item"><a class="page-link" href="#">1</a></li>
					<li class="page-item active" aria-current="page"><a
						class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
					</li>
					<li class="page-item"><a class="page-link" href="#"
						tabindex="1" aria-disabled="true">Siguiente</a></li>

				</ul>
			</nav>

		</div>

		<!--Footer-->
		<div class="col-md-12 pie">
                <footer>
                    <h4>©Derechos Reservados 2019</h4>
                    Universidad Tecnologíca del Norte de Guanajuato.
                </footer>

                <div class="linkUTN">

                    <a title="UTNG" href="https://www.utng.edu.mx/">
                    <img class="linkUTNG" width="15%" src="${pageContext.request.contextPath}/resources/img/linkUTNG.png" alt="UTNG" />
                    </a>

                </div>
                <div class="linkfacebook">

                    <a title="UTNG" href="https://es-la.facebook.com/UTNGDOLORESHIDALGO-222209577812067/">
                    <img class="linkUTNG" width="8%" src="${pageContext.request.contextPath}/resources/img/logofacebook.png" alt="UTNG" />
                    </a>
                    
                </div>

            </div>
          <!--Fin del footer-->

	</section>
</body>

<!-- Inicio de Scripts -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
<!-- Fin de Scripts -->

</html>