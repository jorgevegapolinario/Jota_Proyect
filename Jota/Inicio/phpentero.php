<?php
  if (isset($_POST["nombre"])) {

    // INICIAR SESIÓN.

    //CREANDO CONEXIÓN
    $connection = new mysqli("localhost", "adminjota", "secret", "Jota");
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