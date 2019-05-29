<?php
  if (isset($_POST["nombre"])) {

    // INICIAR SESIÓN.

    //CREANDO CONEXIÓN
    $connection = new mysqli("localhost", "root", "Admin2015", "Jota");
    $connection->set_charset("uft8");

    //PROBAMOS QUE ESTÉ CORRECTA LA CONEXIÓN.
    if ($connection->connect_errno) {
        printf("Connection failed: %s\n", $connection->connect_error);
        exit();
    }

    //HACEMOS LA CONSULTA.
    //Pass cifrada con md5.
    $consulta="SELECT * FROM Usuarios WHERE
    Nombre='".$_POST["nombre"]."' and Pass=md5('".$_POST["pass"]."');";

    //PROBAMOS LA CONSULTA.
    if ($result = $connection->query($consulta)) {

        //No retorna líneas.
        if ($result->num_rows===0) {
          echo '<script language="javascript">alert("Login Inválido.");</script>';
        } else {
          //Login válido.
          $obj=$result->fetch_object();
          $_SESSION["Nombre"]=$_POST["nombre"];
          $_SESSION["language"]="es";
          $_SESSION["Id_Usuario"]=$obj->Id_Usuario;

          if (isset($_SESSION["Id_Usuario"])) {
            // Si el Id_Usuario está definido, entra a la aplicación.
            header("Location: ../../Contenedores/Contenedores.php");
          }
        }

    } else {
      echo "El nombre de usuario o la contraseña no son correctos.<br>
      ¿Si aún no te has registrado, a qué esperas? <label for='tab-1'>¡Adelante!</label>";
    };
  };
?>

<?php // --------------------------------------------------------- ?>

<?php

	if (isset($_POST["nombrereg"])) {

        // REGISTRO.

	    //CONSULTA PARA CREAR EL USUARIO EN LA BASE DE DATOS.
	    if ($_POST["passreg"] == $_POST["confpassreg"]){
	
		    $consulta = "INSERT INTO Usuarios (Id_Usuario, Nombre, Correo, Pass) 
            VALUES ('".$_POST['nombrereg']."','".$_POST['correoreg']."',md5('".$_POST['pass']."'),NULL);";
          
		    //PROBAMOS LA CONSULTA DE REGISTRO.
		    if ($result = $connection->query($consulta)) {

				//Registro válido y completado con éxito.
				header("Location: ../../Inicio/Inicio.php");

			}

		}

	}

?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Jota | INICIO</title>
    <link rel="shortcut icon" href="../Imagenes/favicon.ico">
    <link rel="stylesheet" href="Inicio.css">
</head>
<body>

  <div class="login-wrap">
	<div class="login-html">
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">INICIA SESIÓN</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">REGÍSTRATE</label>
		<div class="login-form" method="POST">
			<div class="sign-in-htm">
				<div class="group">
					<label class="label">Nombre de usuario</label>
					<input class="user" type="text" class="input placehold" name="nombre" placeholder="Ecribe tu usuario..." required>
				</div>
				<div class="group">
					<label class="label">Contraseña</label>
					<input type="password" name="pass" placeholder="Inserta tu contraseña..." class="input placehold" data-type="password" required>
				</div>
				<div class="group">
					<input type="submit" class="button" value="Entrar">
				</div>
				<div class="hr"></div>
				<div class="foot-lnk">
					<img id="logo" src="../Imagenes/Logo.png">
				</div>
			</div>
			<div class="sign-up-htm">
				<div class="group">
					<label class="label">Nombre de Usuario</label>
					<input type="text" name="nombrereg" placeholder="Tu usuario deseado..." class="input placehold" required>
				</div>
				<div class="group">
					<label class="label">Contraseña</label>
					<input type="password" name="passreg" placeholder="Ecribe tu contraseña..." class="input placehold" data-type="password" required>
				</div>
				<div class="group">
					<label class="label">Confirmar la contraseña</label>
					<input type="password" name="confpassreg" placeholder="Confirma tu contraseña..." class="input placehold" data-type="password" required>
				</div>
				<div class="group">
					<label class="label">Correo electrónico</label>
					<input type="text" name="correoreg" placeholder="Proporciona tu coreo..." class="input placehold" required>
				</div>
				<div class="group">
					<input type="submit" class="button" value="Registrarme">
				</div>
				<div class="hr"></div>
				<div class="foot-lnk">
					<label for="tab-1">Ya eres miembro?</label>
				</div>
			</div>
		</div>
	</div>
</div>
  
  

</body>

</html>
