<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Menú Administrador</title>
  <link rel="stylesheet" href="css/menu.css" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Gayathri&display=swap" rel="stylesheet">
</head>

<body>
  <script type="text/javascript" src="js/funciones.js"></script>

  <?php
  session_start();

  if (isset($_POST["regPac"])) {

    $conexion = @mysqli_connect('localhost', 'Administrador', '1234', 'consulta');

    $dni = mb_strtoupper($_POST['dni']);
    $nombre = mb_strtoupper($_POST['nombre']);
    $apellido = mb_strtoupper($_POST['apellido']);
    $fechanac = $_POST["fechanac"];
    $sexo = $_POST["sexo"];

    $usuLogin = $_POST["usuLogin"];
    $contra = $_POST['contra1'];

    if (mysqli_connect_errno()) {
      printf("Conexión fallida: %s\n", mysqli_connect_error());
      exit();
    }

    $sql = "INSERT INTO usuarios VALUES ('$dni', '$usuLogin', '$contra' , 'Activo', 'Paciente')";
    $sql2 = "INSERT INTO pacientes VALUES ('$dni', '$nombre', '$apellido' , '$fechanac', '$sexo')";

    if ((mysqli_query($conexion, $sql)) && (mysqli_query($conexion, $sql2))) { ?>
      <script>
        alert("El paciente se ha registrado correctamente");
        document.getElementById("altapac").style.backgroundColor = "#0D9AD7";
      </script>
    <?php
    }
    ?>

    <?php
    mysqli_close($conexion);
  }
  if (isset($_POST["regMed"])) {

    $conexion = @mysqli_connect('localhost', 'Administrador', '1234', 'consulta');

    $dni = mb_strtoupper($_POST['dni']);
    $nombre = mb_strtoupper($_POST['nombre']);
    $apellido = mb_strtoupper($_POST['apellido']);
    $especialidad = mb_strtoupper($_POST["especialidad"]);
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    $usuLogin = $_POST["usuLogin"];
    $contra = $_POST['contra1'];

    if (mysqli_connect_errno()) {
      printf("Conexión fallida: %s\n", mysqli_connect_error());
      exit();
    }

    $sql = "INSERT INTO usuarios VALUES ('$dni', '$usuLogin', '$contra' , 'Activo', 'Medico')";
    $sql2 = "INSERT INTO medicos VALUES ('$dni', '$nombre', '$apellido' , '$especialidad', '$telefono', '$correo')";

    if ((mysqli_query($conexion, $sql)) && (mysqli_query($conexion, $sql2))) { ?>
      <script>
        alert("El médico se ha registrado correctamente");
      </script>
    <?php
    }
    ?>

  <?php
    mysqli_close($conexion);
  }

  if (isset($_POST["cerrarses"])) {
    session_destroy();
    header('Location: index.php');
  }

  $hoy = getdate();
  $fechainicio = $hoy['year'] - 100 . "-01-01";
  $fechafin = $hoy['year'] . "-" . menor10($hoy['mon']) . "-" . menor10($hoy['mday']);


  function menor10($dato)
  {
    if ($dato < 10) {
      $dato = "0" . $dato;
    }
    return $dato;
  }


  $botones = array(['ALTA PACIENTE', 'altapac'], ['ALTA MÉDICO', 'altamed'], ['CERRAR SESIÓN', 'cerrarses']);
  ?>
  <div id="contenedor">
    <header>
      <div id="saludo">
        <h1><?php echo $_SESSION["datos"]["usuLogin"] ?> </h1>
        <br>
        <h3><?php echo $_SESSION["datos"]["usutipo"] ?></h3>
      </div>
      <img src="img/logo.png" alt="logo">
    </header>
    <div id="contenido">
      <nav id="menu">
        <form action="" method="POST">
          <?php
          foreach ($botones as $boton) {
          ?>
            <input type="submit" name="<?php echo $boton[1] ?>" id="<?php echo $boton[1] ?>" <?php if (isset($_POST[$boton[1]])) echo 'style="background-color:#f6b04e; box-shadow:0px 0px 5px black;"' ?> value="<?php echo $boton[0] ?>" <?php if ($boton[1] == 'cerrarses') {
                                                                                                                                                                                                                                              echo 'onclick="return cierreSesion()"';
                                                                                                                                                                                                                                            } ?>>
          <?php
          }
          ?>
        </form>
      </nav>
      <section id="alta">
        <?php
        if (isset($_POST["altapac"])) {
        ?>
          <form action='' method='POST' onsubmit="return altapac()">
            <div id="datos1">
              <h3>DATOS PERSONALES</h3><br>
              <label for="dni">DNI</label><br>
              <input type="text" name="dni" id="dni" value="<?php if (isset($_post["registrar"])) echo $_POST["dni"] ?>" required><br>
              <br>
              <label for="nombre">NOMBRE</label><br>
              <input type="text" name="nombre" id="nombre" minlength="3" required><br>
              <br>
              <label for="apellido">APELLIDO</label><br>
              <input type="text" name="apellido" id="apellido" minlength="5" required>
              <br><br><br>
              <label for="fechanac">NACIMIENTO</label><br>
              <input type="date" name="fechanac" id="fechanac" value="<?php if (isset($_post["registrar"])) echo $_POST["fechanac"] ?>" min="<?php echo $fechainicio ?>" max="<?php echo $fechafin ?>" required>
              <br><br><br>
              &nbsp;&nbsp;&nbsp;<input type="radio" name="sexo" id="sexo" <?php if (isset($sexo) && $sexo == "Masculino") echo "checked"; ?> value="Masculino" checked> Hombre
              &nbsp;&nbsp;&nbsp;<input type="radio" name="sexo" id="sexo" <?php if (isset($sexo) && $sexo == "Femenino") echo "checked"; ?> value="Femenino"> Mujer
              <br><br>
            </div>
            <div id="datos2">
              <h3>DATOS DE ACCESO</h3><br>
              <label for="usuLogin">NOMBRE DE USUARIO</label><br>
              <input type="text" name="usuLogin" id="usuLogin" minlength="6" required><br>
              <br>
              <label for="contra1">CONTRASEÑA</label><br>
              <input type="password" name="contra1" id="contra1" minlength="6" required><br>
              <br>
              <label for="contra2">REPETIR CONTRASEÑA</label><br>
              <input type="password" name="contra2" id="contra2" minlength="6" required><br><br>
              <br><br>
              <input type="submit" name="regPac" id="regPac" value="REGISTRAR" />
            </div>
          </form>
        <?php } else if (isset($_POST["altamed"])) {
          echo '<script> altamed.style.backgroundColor = "#f6b04eb4"</script>';
        ?>
          <form action='' method='POST' onsubmit="return altamed()">
            <div id="datos1">
              <h3>DATOS PERSONALES</h3><br>
              <label for="dni">DNI</label><br>
              <input type="text" name="dni" id="dni" required>
              <br><br>
              <label for="nombre">NOMBRE</label><br>
              <input type="text" name="nombre" id="nombre" required>
              <br><br>
              <label for="apellido">APELLIDO</label><br>
              <input type="text" name="apellido" id="apellido" required>
              <br><br>
              <label for="telefono">TELÉFONO</label><br>
              <input type="tel" name="telefono" id="telefono" pattern="^[5-9][0-9]{8}" required>
              <br><br>
              <label for="correo">CORREO</label><br>
              <input type="email" name="correo" id="correo" required>
            </div>
            <div id="datos2">
              <h3>DATOS DE ACCESO</h3>
              <br>
              <label for="usuLogin">NOMBRE DE USUARIO</label><br>
              <input type="text" name="usuLogin" id="usuLogin" required>
              <br><br>
              <label for="contra1">CONTRASEÑA</label><br>
              <input type="password" name="contra1" id="contra1" required>
              <br><br>
              <label for="contra2">REPETIR CONTRASEÑA</label><br>
              <input type="password" name="contra2" id="contra2" required>
              <br><br>
              <hr><br>
              <label for="especialidad">ESPECIALIDAD</label><br>
              <input type="text" name="especialidad" id="especialidad" required>
              <br><br><br>
              <input type="submit" name="regMed" id="regMed" value="REGISTRAR" />
            </div>
          </form>
        <?php } else { ?>
          <h2>PARA INICIAR UNA TAREA <br><br> SELECCIONE UNA OPCIÓN</h2>
        <?php } ?>
        <span id="error"></span>
      </section>
    </div>
    <footer id="footer">
      <div id="time">
      </div>
      <div id="aviso">
        <h4>VÍCTOR EMMANUEL MOLINAS - 2020</h4>
      </div>
    </footer>
  </div>
</body>

</html>