<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Clínica - Víctor Emmanuel Molinas</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
  <?php
  session_start();
  if (isset($_POST["acceder"])) {
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    $conexion = @mysqli_connect('localhost', 'acceso', '1234', 'consulta');
    if (mysqli_connect_errno()) {
      printf("Conexión fallida: %s\n", mysqli_connect_error());
      exit();
    } else {

      $sql = 'SELECT usuLogin, usuPassword, usutipo, dniUsu from usuarios where usuLogin="' . $user . '" and usuPassword="' . $pass . '"';
      $resultado = mysqli_query($conexion, $sql);

      $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

      if ($row == null) {
        $error = "ERROR: Usuario y/o Contraseña no valido/s";
      } else {
        $_SESSION["datos"] = $row;

        if ($_SESSION["datos"]["usutipo"] == "Administrador") {
          mysqli_close($conexion);
          header('Location: menuAdmin.php');
        } else if ($_SESSION["datos"]["usutipo"] == "Asistente") {
          mysqli_close($conexion);
          header('Location: menuAsis.php');
        } else if ($_SESSION["datos"]["usutipo"] == "Medico") {
          mysqli_close($conexion);
          header('Location: menuMed.php');
        } else if ($_SESSION["datos"]["usutipo"] == "Paciente") {
          mysqli_close($conexion);
          header('Location: menuPac.php');
        }
      }
    }
  } else {
    $error = "";
  }
  ?>
  <section id="acceso">
    <h1>CENTRO MÉDICO ADSI VIRTUAL</h1>
    <h2>INICIO DE SESIÓN</h2>
    <form action="" method="POST">
      <label for="user">USUARIO</label>
      <br>
      <input type="text" name="user" value="<?php if (isset($_POST["acceder"])) echo $_POST["user"] ?>" required>
      <br><br>
      <label for="pass">CONTRASEÑA</label>
      <br>
      <input type="password" name="pass" value="<?php if (isset($_POST["acceder"])) echo $_POST["pass"] ?>" required>
      <br><br><br>
      <input type="submit" name="acceder" id="acceder" value="ACCEDER">
    </form>
    <br>
    <span name="error" id="error"><?php echo $error ?></span>

  </section>
</body>

</html>