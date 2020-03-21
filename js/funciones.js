window.onload = function() {
  document.getElementById("contenedor").style.height = window.innerHeight + "px";
  tiempo();
}

function tiempo() {
  var reloj = setInterval(function() {
      var dato = new Date();

      time.innerHTML = "HORA: " + digito(dato.getHours()) + ":" + digito(dato.getMinutes()) + ":" + digito(dato.getSeconds()) + "<br>";
      time.innerHTML += "FECHA: " + digito(dato.getDate()) + "/" + digito(dato.getMonth() + 1) + "/" + dato.getFullYear();
    },
    1000);
}

function digito(valor) {
  if (valor < 10 && valor.toString().length < 2) {
    return "0" + valor;
  } else {
    return valor.toString();
  }
}

function altapac() {
  var dni = document.getElementById('dni');
  var nombre = document.getElementById('nombre');
  var apellido = document.getElementById('apellido');
  var contra1 = document.getElementById('contra1');
  var contra2 = document.getElementById('contra2');

  var dniRexp = /^[0-9]{8}[a-zA-Z]$/i;
  var nombreRexp = /^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/g;
  var apellidoRexp = /^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/g;
  var aviso = " ";
  console.log(aviso);

  if (!dniRexp.test(dni.value)) {
    aviso = "Formato de DNI incorrecto";
  }

  if (!nombreRexp.test(nombre.value)) {
    aviso += "\nFormato de nombre incorrecto. Solo son válidos letras y espacios en blanco";
  }

  if (!apellidoRexp.test(apellido.value)) {
    aviso += "\nFormato de apellido incorrecto. Solo son válidos letras y espacios en blanco";
  }

  if (contra1.value != contra2.value) {
    aviso += "\nLa contraseña no coincide";
  }

  if (aviso == " ") {
    return true;
  } else {
    alert(aviso);
    return false;
  }
}

function altamed() {
  var dni = document.getElementById('dni');
  var nombre = document.getElementById('nombre');
  var apellido = document.getElementById('apellido');
  var especialidad = document.getElementById('especialidad');

  var contra1 = document.getElementById('contra1');
  var contra2 = document.getElementById('contra2');

  var dniRexp = /^[0-9]{8}[a-zA-Z]$/i;
  var nombreRexp = /^[A-Za-z\s]+$/g;
  var apellidoRexp = /^[A-Za-z\s]+$/g;
  var especialidadRexp = /^[a-zA-Z]{3,}$/;
  var aviso = " ";
  console.log(aviso);

  if (!dniRexp.test(dni.value)) {
    aviso = "Formato de DNI incorrecto";
  }

  if (!nombreRexp.test(nombre.value)) {
    aviso += "\nFormato de nombre incorrecto. Solo son válidos letras y espacios en blanco";
  }

  if (!apellidoRexp.test(apellido.value)) {
    aviso += "\nFormato de apellido incorrecto. Solo son válidos letras y espacios en blanco";
  }

  if (!especialidadRexp.test(especialidad.value)) {
    aviso += "\nFormato de especialidad incorrecto. Solo son válidos letras y espacios en blanco";
  }

  if (contra1.value != contra2.value) {
    aviso += "\nLa contraseña no coincide";
  }

  if (aviso == " ") {
    return true;
  } else {
    console.log(aviso);
    alert(aviso);
    return false;
  }
}

function cierreSesion() {
  return confirm("¿Está seguro que desea cerrar sesión?");
}