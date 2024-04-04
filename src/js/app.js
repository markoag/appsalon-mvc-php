let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
  id: "",
  nombre: "",
  fecha: "",
  hora: "",
  servicios: [],
};

document.addEventListener("DOMContentLoaded", () => {
  iniciarApp();
});

function iniciarApp() {
  mostrarSeccion(); // Función para mostrar la sección definida
  tabs(); // Función para cambiar de pestaña
  botonesPaginador(); // Agg o quita los botones de paginación
  paginaSiguiente();
  paginaAnterior();
  consultarAPI();
  clienteID();
  nombreCliente(); // Función para obtener el nombre del cliente
  seleccionarFecha();
  seleccionarHora();
  mostrarResumen();
}

function mostrarSeccion() {
  // Ocultar la sección anterior
  const seccionAnterior = document.querySelector(".mostrar");
  if (seccionAnterior) {
    seccionAnterior.classList.remove("mostrar");
  }

  // Seleccionar la sección actual
  const pasoSelector = `#paso-${paso}`;
  const seccion = document.querySelector(pasoSelector);
  seccion.classList.add("mostrar");

  // Quitar la clase de actual en el tab anterior
  const tabAnterior = document.querySelector(".actual");
  if (tabAnterior) {
    tabAnterior.classList.remove("actual");
  }

  // Resaltar el tab actual
  const tab = document.querySelector(`[data-paso="${paso}"]`);
  tab.classList.add("actual");
}

function tabs() {
  const botones = document.querySelectorAll(".tabs button");

  botones.forEach((boton) => {
    boton.addEventListener("click", function (e) {
      paso = parseInt(e.target.dataset.paso);

      mostrarSeccion();
      botonesPaginador();
    });
  });
}

function botonesPaginador() {
  const paginaAnterior = document.querySelector("#anterior");
  const paginaSiguiente = document.querySelector("#siguiente");

  if (paso === 1) {
    paginaAnterior.classList.add("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  } else if (paso === 3) {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.add("ocultar");
    mostrarResumen();
  } else {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  }
  mostrarSeccion();
}

function paginaAnterior() {
  const paginaAnterior = document.querySelector("#anterior");
  paginaAnterior.addEventListener("click", () => {
    if (paso <= pasoInicial) return;
    paso--;

    botonesPaginador();
  });
}

function paginaSiguiente() {
  const paginaSiguiente = document.querySelector("#siguiente");
  paginaSiguiente.addEventListener("click", () => {
    if (paso >= pasoFinal) return;
    paso++;

    botonesPaginador();
  });
}

async function consultarAPI() {
  try {
    const url = `${location.origin}/api/servicios`;
    const resultado = await fetch(url);
    const servicios = await resultado.json();
    mostrarServicios(servicios);
  } catch (error) {
    console.log(error);
  }
}

function mostrarServicios(servicios) {
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;

    const nombreServicio = document.createElement("P");
    nombreServicio.textContent = nombre;
    nombreServicio.classList.add("nombre-servicio");

    const precioServicio = document.createElement("P");
    precioServicio.textContent = `$ ${precio}`;
    precioServicio.classList.add("precio-servicio");

    const divServicio = document.createElement("DIV");
    divServicio.classList.add("servicio");
    divServicio.dataset.idServicio = id;
    divServicio.onclick = function () {
      seleccionarServicio(servicio);
    };

    divServicio.appendChild(nombreServicio);
    divServicio.appendChild(precioServicio);

    document.querySelector("#servicios").appendChild(divServicio);
  });
}

function seleccionarServicio(servicio) {
  const { servicios } = cita;
  const { id } = servicio;

  // Indentifica al elemento seleccionado
  const servicioDiv = document.querySelector(`[data-id-servicio="${id}"]`);

  // Verificar si el servicio ya está seleccionado
  if (servicios.some((agregado) => agregado.id === id)) {
    // Eliminarlo
    cita.servicios = servicios.filter((agregado) => agregado.id !== id);
    servicioDiv.classList.remove("seleccionado");
  } else {
    // Agregarlo
    cita.servicios = [...servicios, servicio];
    servicioDiv.classList.add("seleccionado");
  }
}
function clienteID() {
  cita.id = document.querySelector("#id").value;
}
function nombreCliente() {
  cita.nombre = document.querySelector("#nombre").value;
}

function seleccionarFecha() {
  const inputFecha = document.querySelector("#fecha");
  inputFecha.addEventListener("input", (e) => {
    const dia = new Date(e.target.value).getUTCDay();
    if ([0, 6].includes(dia)) {
      e.preventDefault();
      inputFecha.value = "";
      mostrarAlerta("Fines de semana no permitidos", "error", ".formulario");
    } else {
      cita.fecha = inputFecha.value;
    }
  });
}
function seleccionarHora() {
  const inputHora = document.querySelector("#hora");
  inputHora.addEventListener("input", (e) => {
    const horaCita = e.target.value;
    const hora = horaCita.split(":");
    if (hora[0] < 9 || hora[0] > 16) {
      mostrarAlerta("Hora no válida", "error", ".formulario");
      setTimeout(() => {
        inputHora.value = "";
      }, 3000);
    } else {
      cita.hora = horaCita;
    }
  });
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
  const alertaPrevia = document.querySelector(".alerta");
  if (alertaPrevia) {
    alertaPrevia.remove();
  }

  const alerta = document.createElement("DIV");
  alerta.textContent = mensaje;
  alerta.classList.add("alerta");
  alerta.classList.add(tipo);

  const referencia = document.querySelector(elemento);
  referencia.appendChild(alerta);

  if (desaparece) {
    setTimeout(() => {
      alerta.remove();
    }, 3000);
  }
}

function mostrarResumen() {
  const resumen = document.querySelector(".contenido-resumen");

  // Limpiar el HTML previo
  while (resumen.firstChild) {
    resumen.removeChild(resumen.firstChild);
  }

  if (Object.values(cita).includes("") || cita.servicios.length === 0) {
    mostrarAlerta(
      "Faltan datos de servicios , fecha u hora",
      "error",
      ".contenido-resumen",
      false
    );
    return;
  }

  // Formatear el resumen
  const { nombre, fecha, hora, servicios } = cita;

  // Heading para el servicio
  const headingServicio = document.createElement("H3");
  headingServicio.textContent = "Resumen de Servicios";
  resumen.appendChild(headingServicio);

  // Iterando y mostrando los servicios
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;
    const contenedorServicio = document.createElement("DIV");
    contenedorServicio.classList.add("contenedor-servicio");

    const textoServicio = document.createElement("P");
    textoServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

    contenedorServicio.appendChild(textoServicio);
    contenedorServicio.appendChild(precioServicio);

    resumen.appendChild(contenedorServicio);
  });

  // Heading para el cliente
  const headingResumen = document.createElement("H3");
  headingResumen.textContent = "Resumen de Cita";
  resumen.appendChild(headingResumen);

  const nombreCliente = document.createElement("P");
  nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

  // Formatear la fecha
  const fechaObj = new Date(fecha);
  const mes = fechaObj.getMonth();
  const dia = fechaObj.getDate() + 2;
  const year = fechaObj.getFullYear();

  const fechaUTC = new Date(Date.UTC(year, mes, dia));

  const fechaFormateada = fechaUTC.toLocaleDateString("es-MX", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  });

  const fechaCita = document.createElement("P");
  fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

  const horaCita = document.createElement("P");
  horaCita.innerHTML = `<span>Hora:</span> ${hora} Hrs`;

  // Botón para confirmar la cita
  const botonReservar = document.createElement("BUTTON");
  botonReservar.textContent = "Reservar Cita";
  botonReservar.classList.add("boton");
  botonReservar.onclick = reservarCita;

  resumen.appendChild(nombreCliente);
  resumen.appendChild(fechaCita);
  resumen.appendChild(horaCita);
  resumen.appendChild(botonReservar);
}

async function reservarCita() {
  const { nombre, fecha, hora, servicios, id } = cita;

  const serviciosId = servicios.map((servicio) => servicio.id);

  const datos = new FormData();
  datos.append("fecha", fecha);
  datos.append("hora", hora);
  datos.append("usuarioId", id);
  datos.append("servicios", serviciosId);

  // Agg auditoria de la cita
  // Obtener la fecha actual en tu zona horaria real y en el formato deseado
  const now = new Date().toLocaleString("es-EC", {
    timeZone: "America/Guayaquil",
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
  });

  // Formatear la fecha al formato DD-MM-YYYY HH:MM:SS
  const formattedDate =
    now.split(" ")[0].split("/").reverse().join("-").replace(/,/g, "") + " " + now.split(" ")[1];

  // Guardar la fecha formateada en tu base de datos

  datos.append("createdAt", formattedDate);
  datos.append("updatedAt", formattedDate);

  // return console.log([...datos]);

  try {
    // Petición a la API
    const url = `${location.origin}/api/citas`;

    const respuesta = await fetch(url, {
      method: "POST",
      body: datos,
    });

    const resultado = await respuesta.json();

    if (resultado.resultado) {
      Swal.fire({
        icon: "success",
        title: "Cita Reservada!",
        text: "Se ha reservado la cita correctamente!",
        button: "Ok",
      }).then(() => {
        window.location.reload();
      });
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error!",
      text: "Hubo un error al reservar la cita, intenta de nuevo!",
    });
  }
}
