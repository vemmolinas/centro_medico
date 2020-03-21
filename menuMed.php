<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Menú Médico</title>
  <link rel="stylesheet" href="css/menu.css" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Gayathri&display=swap" rel="stylesheet">
</head>

<body>
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

  $botones = array(['CITAS ATENDIDAS', 'citasAtend'], ['CITAS PENDIENTES', 'citasPend'], ['VER PACIENTES', 'pacientes'], ['CERRAR SESIÓN', 'cerrarses']);
  ?>
  <div id="contenedor">
    <header>
      <div id="saludo">
        <h1><?php
            $conexion = @mysqli_connect('localhost', 'Medico', '1234', 'consulta');

            if (mysqli_connect_errno()) {
              printf("Conexión fallida: %s\n", mysqli_connect_error());
              exit();
            } else {
            }

            $sql = "SELECT medNombres, medApellidos from medicos where dniMed='" . $_SESSION["datos"]["dniUsu"] . "';";
            $resultado = mysqli_query($conexion, $sql);
            // var_dump($conexion);
            while ($registro = mysqli_fetch_row($resultado)) {
              echo $registro[0] . " " . $registro[1];
            }
            mysqli_close($conexion);
            ?> </h1>
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
        if (isset($_POST["citasAtend"])) {
          $conexion = @mysqli_connect('localhost', 'Medico', '1234', 'consulta');

          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
          }

          $sql = "SELECT c.citFecha, c.citHora, p.pacNombres, p.pacApellidos, con.conNombre, c.citObservaciones, c.citEstado, m.dniMed
                  from medicos m
                  INNER JOIN citas c on m.dniMed=c.citMedico
                  INNER JOIN consultorios con on c.citConsultorio=con.idConsultorio
                  INNER JOIN pacientes p on p.dniPac=c.citPaciente
                  WHERE c.citEstado = 'Atendido' and m.dniMed = '" . $_SESSION["datos"]["dniUsu"] . "'
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
                <th>CONSULTORIO</th>
                <th>OBSERVACIONES</th>
              </tr>
              <?php

              while ($registro = mysqli_fetch_row($resultado)) {
                echo "<tr><td>" . date("d/m/Y", strtotime($registro[0])) . "</td><td>" . date("h:i", strtotime($registro[1]))  . "</td><td>" .  $registro[2]  . " " .  $registro[3]  . "</td><td>" .  $registro[4]  . "</td><td>" .  $registro[5] . "</td></tr>";
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

          <?php } else if (isset($_POST["citasPend"])) {
          $conexion = @mysqli_connect('localhost', 'Medico', '1234', 'consulta');

          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
          }

          $sql = "SELECT c.citFecha, c.citHora, p.pacNombres, p.pacApellidos, con.conNombre, c.idCita
                  from medicos m
                  INNER JOIN citas c on m.dniMed=c.citMedico
                  INNER JOIN consultorios con on c.citConsultorio=con.idConsultorio
                  INNER JOIN pacientes p on p.dniPac=c.citPaciente
                  WHERE c.citEstado = 'Asignado'and m.dniMed = '" . $_SESSION["datos"]["dniUsu"] . "'
                  ORDER BY c.citFecha ASC;";

          $resultado = mysqli_query($conexion, $sql);
          $total = mysqli_num_rows($resultado);

          if ($total != 0) {
          ?>
            <form action="" method="POST">
              <table id="citas">
                <tr>
                  <th>FECHA</th>
                  <th>HORA</th>
                  <th>PACIENTE</th>
                  <th>CONSULTORIO</th>
                  <th>ATENDER</th>
                </tr>
                <?php

                while ($registro = mysqli_fetch_row($resultado)) {
                  echo "<tr><td>" . date("d/m/Y", strtotime($registro[0])) . "</td><td>" . date("h:i", strtotime($registro[1]))  . "</td><td>" .  $registro[2]  . " " .  $registro[3]  . "</td><td>" .  $registro[4]  . "</td><td><button type='submit' name='atender' class='atender' value='" . $registro[5] . "'></button></td></tr>";
                }
                ?>
              </table>
            </form>
          <?php
          } else {
            echo "<h2>NO HAY REGISTRO DE CITAS PASADAS</h2>";
          }
          mysqli_close($conexion);
          ?>
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

        } else if (isset($_POST["atender"])) {
          $conexion = @mysqli_connect('localhost', 'Medico', '1234', 'consulta');
          $sql4 = "SELECT p.pacNombres, p.pacApellidos, c.citFecha
                  from pacientes p INNER JOIN citas c on p.dniPac = c.citPaciente
                  WHERE c.idCita =" . $_POST["atender"] . ";";

          $_SESSION["atender"] = $_POST["atender"];

          $resultado = mysqli_query($conexion, $sql4);

          while ($registro = mysqli_fetch_row($resultado)) {
          ?>
            <form action="" method="POST" id="atendiendo">
              <table style="text-align:left">
                <tr>
                  <td><strong>PACIENTE:</strong> <?php echo $registro[0] . " " . $registro[1]; ?></td>
                </tr>
                <tr>
                  <td><strong>CITA:</strong> <?php echo $_SESSION["atender"] . "-" . date("d/m/Y", strtotime($registro[2])) ?></td>
                </tr>
                <tr>
                  <td></td>
                </tr>
                <tr>
                  <td><strong>OBSERVACIONES</strong><br><textarea name="observaciones" rows="10" cols="50"></textarea></td>
                </tr>
                <tr>
                  <td></td>
                </tr>
                <tr>
                  <td><input type="submit" name="finalizar" id="finalizar" value="FINALIZAR"></td>
                </tr>
              </table>
            </form>
          <?php
          }
          mysqli_close($conexion);
        } else if (isset($_POST["finalizar"])) {

          $conexion = @mysqli_connect('localhost', 'Medico', '1234', 'consulta');


          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
          }

          $sql3 = "UPDATE citas SET citEstado='Atendido', CitObservaciones='" . $_POST["observaciones"] . "' WHERE idCita='" . $_SESSION["atender"] . "' ;";

          if (mysqli_multi_query($conexion, $sql3)) {
          ?>
            <script>
              alert("Registro de cita actualizado: ATENDIDO");
            </script>
          <?php
          }

          mysqli_close($conexion);
        } else { ?>
          <h2>PARA INICIAR UNA TAREA <br><br> SELECCIONE UNA OPCIÓN</h2>
        <?php }
        ?>
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
  <?php

  if (isset($_POST["ver"])) {
    $conexion = @mysqli_connect('localhost', 'Medico', '1234', 'consulta');

    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fechanac = $_POST["fechanac"];
    $sexo = $_POST["sexo"];

    $usuLogin = $_POST["usuLogin"];
    $contra = $_POST['contra1'];

    if (mysqli_connect_errno()) {
      printf("Conexión fallida: %s\n", mysqli_connect_error());
      exit();
    }

    mysqli_close($conexion);
  }


  if (isset($_POST["cerrarses"])) {
    session_destroy();
    header('Location: index.php');
  }
  ?>
</body>

</html>