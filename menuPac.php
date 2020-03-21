<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Menú Paciente</title>
  <link rel="stylesheet" href="css/menu.css" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Gayathri&display=swap" rel="stylesheet">
</head>

<body>
  <script type="text/javascript" src="js/funciones.js"></script>

  <?php
  session_start();

  $hoy = getdate();

  function menor10($dato)
  {
    if ($dato < 10) {
      $dato = "0" . $dato;
    }
    return $dato;
  }
  $hoy = $hoy['year'] . "-" . menor10($hoy['mon'])  . "-" . menor10($hoy['mday']);

  $botones = array(['CITAS PASADAS', 'citasPas'], ['CITAS PENDIENTES', 'citasPend'], ['CERRAR SESIÓN', 'cerrarses']);
  ?>
  <div id="contenedor">
    <header>
      <div id="saludo">
        <h1><?php
            $conexion = @mysqli_connect('localhost', 'Paciente', '1234', 'consulta');

            if (mysqli_connect_errno()) {
              printf("Conexión fallida: %s\n", mysqli_connect_error());
              exit();
            } else {
            }

            $sql = "SELECT pacNombres, pacApellidos from pacientes where dniPac='" . $_SESSION["datos"]["dniUsu"] . "';";
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
        if (isset($_POST["citasPas"]) || isset($_POST["citasPend"])) {
          $conexion = @mysqli_connect('localhost', 'Paciente', '1234', 'consulta');

          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
          }

          if (isset($_POST["citasPas"])) {
            $control = "Atendido";
            $citas = "NO HAY REGISTRO DE CITAS PASADAS";
          } else if (isset($_POST["citasPend"])) {
            $control = "Asignado";
            $citas = "NO HAY REGISTRO DE CITAS ASIGNADAS";
          }

          $sql = "SELECT c.citFecha, c.citHora, m.medNombres, m.medApellidos, con.conNombre, c.CitObservaciones, c.citEstado
                  from medicos m 
                  INNER JOIN citas c on m.dniMed=c.citMedico 
                  INNER JOIN consultorios con on c.citConsultorio=con.idConsultorio 
                  WHERE c.citPaciente='" . $_SESSION["datos"]["dniUsu"] . "'
                  AND c.citEstado = '" . $control . "'
                  ORDER BY c.citFecha ASC;";

          $resultado = mysqli_query($conexion, $sql);
          $total = mysqli_num_rows($resultado);

          if ($total != 0) {
        ?>
            <table id="citas">
              <tr>
                <th>FECHA</th>
                <th>HORA</th>
                <th>MÉDICO</th>
                <th>CONSULTORIO</th>
                <?php if (isset($_POST["citasPas"])) { ?>
                  <th>OBSERVACIONES</th>
                <?php } ?>
              </tr>
              <?php

              while ($registro = mysqli_fetch_row($resultado)) {
?>
                <tr><td><?php echo date("d/m/Y", strtotime($registro[0])) ?></td><td><?php echo date("h:i", strtotime($registro[1])) ?> </td><td><?php echo  $registro[2]  . " " .  $registro[3]  ?></td><td><?php echo  $registro[4] ; if (isset($_POST["citasPas"]))  echo "</td><td>" .  $registro[5]  ?></td></tr>
<?php
              }
              ?>
            </table>
          <?php
          } else {
            echo "<h2>" . $citas . "</h2>";
          }
          mysqli_close($conexion);
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
  <?php
  if (isset($_POST["cerrarses"])) {
    session_destroy();
    header('Location: index.php');
  }
  ?>
</body>

</html>