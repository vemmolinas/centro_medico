<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Menú Asistente</title>
  <link rel="stylesheet" href="css/menu.css" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Gayathri&display=swap" rel="stylesheet">
</head>

<body>
  <?php
  if (isset($_POST["regPac"])) {

    $conexion = @mysqli_connect('localhost', 'Asistente', '1234', 'consulta');

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
      </script>
    <?php
    }
    ?>

    <?php
    mysqli_close($conexion);
  }
  if (isset($_POST["regCita"])) {
    $conexion = @mysqli_connect('localhost', 'Asistente', '1234', 'consulta');

    $paciente = $_POST["nombrePac"];
    $fecha =  $_POST["fechacita"];
    $hora = $_POST["horacita"];
    $medico = $_POST["nombreMed"];
    $consultorio = $_POST["nombreCon"];

    $fecha = str_replace("-", "", $fecha);

    $sql3 = "INSERT INTO citas VALUES (' ',  $fecha , $hora , '$paciente', '$medico', '$consultorio', 'Asignado', ' ' )";

    if (mysqli_multi_query($conexion, $sql3)) {
    ?>
      <script>
        alert("La cita se ha registrado correctamente");
      </script>
  <?php
    }
    mysqli_close($conexion);
  }

  if (isset($_POST["cerrarses"])) {
    session_destroy();
    header('Location: index.php');
  }
  ?>
  <script type="text/javascript" src="js/funciones.js"></script>

  <?php
  session_start();
  $hoy = getdate();
  $fechainicio = $hoy['year'] - 100 . "-01-01";

  function menor10($dato)
  {
    if ($dato < 10) {
      $dato = "0" . $dato;
    }
    return $dato;
  }
  $fechafin = $hoy['year'] . "-" . menor10($hoy['mon'])  . "-" . menor10($hoy['mday']);

  $botones = array(['CITAS ATENDIDAS', 'citasAtend'], ['NUEVA CITA', 'nuevaCita'], ['ALTA PACIENTE', 'altapac'], ['VER PACIENTES', 'pacientes'], ['CERRAR SESIÓN', 'cerrarses']);
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

          <?php } else if (isset($_POST["citasAtend"])) {
          $conexion = @mysqli_connect('localhost', 'Asistente', '1234', 'consulta');

          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
          }

          $sql = "SELECT c.citFecha, c.citHora, p.pacNombres, p.pacApellidos, m.medNombres, m.medApellidos, con.conNombre, c.citObservaciones, c.citEstado
                  from medicos m
                  INNER JOIN citas c on m.dniMed=c.citMedico
                  INNER JOIN consultorios con on c.citConsultorio=con.idConsultorio
                  INNER JOIN pacientes p on p.dniPac=c.citPaciente
                  WHERE c.citEstado = 'Atendido'
                  ORDER BY c.citFecha ASC;";

          $resultado = mysqli_query($conexion, $sql);
          $total = mysqli_num_rows($resultado);

          if ($total != 0) {
          ?>
            <table id="citas">
              <tr>
                <th>FECHA</th>
                <th>HORA</th>
                <th>PACIENTE</th>
                <th>MÉDICO</th>
                <th>CONSULTORIO</th>
                <th>OBSERVACIONES</th>
              </tr>
              <?php

              while ($registro = mysqli_fetch_row($resultado)) {
                echo "<tr><td>" . date("d/m/Y", strtotime($registro[0])) . "</td><td>" . date("h:i", strtotime($registro[1]))  . "</td><td>" .  $registro[2]  . " " .  $registro[3]  . "</td><td>" .  $registro[4]  . " " .  $registro[5] . "</td><td>" . $registro[6] . "</td><td>" . $registro[7] . "</td></tr>";
              }
              ?>
            </table>
          <?php
          } else {
            echo "<h2>NO HAY REGISTRO DE CITAS PASADAS</h2>";
          }
          mysqli_close($conexion);
          ?>
          </table>

        <?php } else if (isset($_POST["nuevaCita"])) {
          $conexion = @mysqli_connect('localhost', 'Asistente', '1234', 'consulta');

          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
          }
        ?>
          <div id="datos1">
            <form action='' method='POST'>
              <label for="nombrePac">PACIENTE</label><br>
              <select name="nombrePac" id="nombrePac" value="<?php if (isset($_post["registrar"])) echo $_POST["nombrePac"] ?>" required>
                <option selected="selected">ELEGIR PACIENTE</option>
                <?php
                $sql = "SELECT dniPac, pacNombres, pacApellidos from pacientes;";

                $resultado = mysqli_query($conexion, $sql);
                while ($registro = mysqli_fetch_row($resultado)) {
                  echo "<option value='" . $registro[0] . "'>" . $registro[1] . " " . $registro[2]  . "</option>";
                }
                mysqli_close($conexion);
                ?>
              </select><br><br>
              <label for="fechacita">FECHA</label><br>
              <input type="date" name="fechacita" id="fechacita" value="<?php if (isset($_post["registrar"])) echo $_POST["fechacita"] ?>" min="<?php echo $fechafin ?>" required><br><br>
              <label for="horacita">HORA</label><br>
              <select type="time" name="horacita" id="horacita" required>
                <option selected="selected">ELEGIR HORA</option>
                <?php
                $hora = 8;
                for ($minutos = 0; $hora <= 14; $minutos += 15) {
                  if ($minutos > 45) {
                    $minutos = 0;
                    $hora++;
                  }
                ?>
                  <option value="<?php echo menor10($hora) . menor10($minutos) . "00" ?>"><?php echo menor10($hora) . ':' . menor10($minutos) ?></option>
                <?php
                }
                ?>
              </select>
          </div>
          <div id="datos2">
            <label for="nombreMed">MÉDICO</label><br>
            <select name="nombreMed" id="nombreMed" value="<?php if (isset($_post["registrar"])) echo $_POST["nombreMed"] ?>" required>
              <option selected="selected">ELEGIR MÉDICO</option>
              <?php
              $conexion = @mysqli_connect('localhost', 'Asistente', '1234', 'consulta');
              if (mysqli_connect_errno()) {
                printf("Conexión fallida: %s\n", mysqli_connect_error());
                exit();
              } else {
              }
              $sql2 = "SELECT dniMed, medNombres, medApellidos from medicos;";
              $resultado = mysqli_query($conexion, $sql2);
              while ($registro = mysqli_fetch_row($resultado)) {
                echo "<option value='" . $registro[0] . "'>" . $registro[1] . " " . $registro[2]  . "</option>";
              }
              mysqli_close($conexion);
              ?>
            </select><br><br>

            <label for="nombreCon">CONSULTORIO</label><br>
            <select name="nombreCon" id="nombreCon" value="<?php if (isset($_post["registrar"])) echo $_POST["nombreCon"] ?>" required>
              <option selected="selected">ELEGIR CONSULTORIO</option>
              <?php
              $conexion = @mysqli_connect('localhost', 'Asistente', '1234', 'consulta');

              if (mysqli_connect_errno()) {
                printf("Conexión fallida: %s\n", mysqli_connect_error());
                exit();
              } else {
              }
              $sql2 = "SELECT * from consultorios;";

              $resultado = mysqli_query($conexion, $sql2);

              while ($registro = mysqli_fetch_row($resultado)) {
                echo "<option value='" . $registro[0] . "'>" . $registro[1] . "</option>";
              }
              mysqli_close($conexion);
              ?>
            </select><br><br><br>

            <input type="submit" name="regCita" id="regCita" value="REGISTRAR" />
          </div>
          </form>
        <?php
        } else if (isset($_POST["pacientes"])) {
          $conexion = @mysqli_connect('localhost', 'Asistente', '1234', 'consulta');

          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
          }

          $sql = "SELECT * from pacientes;";

          $resultado = mysqli_query($conexion, $sql);

        ?>
          <table id="citas">
            <tr>
              <th>DNI</th>
              <th>NOMBRE</th>
              <th>APELLIDO</th>
              <th>FECHA DE NAC.</th>
              <th>SEXO</th>
            </tr>
            <?php

            while ($registro = mysqli_fetch_row($resultado)) {
              echo "<tr><td>" . $registro[0]  . "</td><td>" . $registro[1]  . "</td><td>" .  $registro[2]  . "</td><td>" .  date("d/m/Y", strtotime($registro[3])) .  "</td><td>" . $registro[4] .  "</td></tr>";
            }
            mysqli_close($conexion);
            ?>
          </table>
        <?php


        } else { ?>
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