let paso=1;const pasoInicial=1,pasoFinal=3,cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),paginaSiguiente(),paginaAnterior(),consultarAPI(),clienteID(),nombreCliente(),seleccionarFecha(),seleccionarHora(),mostrarResumen()}function mostrarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");const t="#paso-"+paso;document.querySelector(t).classList.add("mostrar");const o=document.querySelector(".actual");o&&o.classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginador()}))})}function botonesPaginador(){const e=document.querySelector("#anterior"),t=document.querySelector("#siguiente");1===paso?(e.classList.add("ocultar"),t.classList.remove("ocultar")):3===paso?(e.classList.remove("ocultar"),t.classList.add("ocultar"),mostrarResumen()):(e.classList.remove("ocultar"),t.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",()=>{paso<=1||(paso--,botonesPaginador())})}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",()=>{paso>=3||(paso++,botonesPaginador())})}async function consultarAPI(){try{const e=location.origin+"/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:o,precio:a}=e,n=document.createElement("P");n.textContent=o,n.classList.add("nombre-servicio");const c=document.createElement("P");c.textContent="$ "+a,c.classList.add("precio-servicio");const r=document.createElement("DIV");r.classList.add("servicio"),r.dataset.idServicio=t,r.onclick=function(){seleccionarServicio(e)},r.appendChild(n),r.appendChild(c),document.querySelector("#servicios").appendChild(r)})}function seleccionarServicio(e){const{servicios:t}=cita,{id:o}=e,a=document.querySelector(`[data-id-servicio="${o}"]`);t.some(e=>e.id===o)?(cita.servicios=t.filter(e=>e.id!==o),a.classList.remove("seleccionado")):(cita.servicios=[...t,e],a.classList.add("seleccionado"))}function clienteID(){cita.id=document.querySelector("#id").value}function nombreCliente(){cita.nombre=document.querySelector("#nombre").value}function seleccionarFecha(){const e=document.querySelector("#fecha");e.addEventListener("input",t=>{const o=new Date(t.target.value).getUTCDay();[0,6].includes(o)?(t.preventDefault(),e.value="",mostrarAlerta("Fines de semana no permitidos","error",".formulario")):cita.fecha=e.value})}function seleccionarHora(){const e=document.querySelector("#hora");e.addEventListener("input",t=>{const o=t.target.value,a=o.split(":");a[0]<9||a[0]>16?(mostrarAlerta("Hora no válida","error",".formulario"),setTimeout(()=>{e.value=""},3e3)):cita.hora=o})}function mostrarAlerta(e,t,o,a=!0){const n=document.querySelector(".alerta");n&&n.remove();const c=document.createElement("DIV");c.textContent=e,c.classList.add("alerta"),c.classList.add(t);document.querySelector(o).appendChild(c),a&&setTimeout(()=>{c.remove()},3e3)}function mostrarResumen(){const e=document.querySelector(".contenido-resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("Faltan datos de servicios , fecha u hora","error",".contenido-resumen",!1);const{nombre:t,fecha:o,hora:a,servicios:n}=cita,c=document.createElement("H3");c.textContent="Resumen de Servicios",e.appendChild(c),n.forEach(t=>{const{id:o,nombre:a,precio:n}=t,c=document.createElement("DIV");c.classList.add("contenedor-servicio");const r=document.createElement("P");r.textContent=a;const i=document.createElement("P");i.innerHTML="<span>Precio:</span> $"+n,c.appendChild(r),c.appendChild(i),e.appendChild(c)});const r=document.createElement("H3");r.textContent="Resumen de Cita",e.appendChild(r);const i=document.createElement("P");i.innerHTML="<span>Nombre:</span> "+t;const s=new Date(o),d=s.getMonth(),l=s.getDate()+2,u=s.getFullYear(),m=new Date(Date.UTC(u,d,l)).toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),p=document.createElement("P");p.innerHTML="<span>Fecha:</span> "+m;const v=document.createElement("P");v.innerHTML=`<span>Hora:</span> ${a} Hrs`;const h=document.createElement("BUTTON");h.textContent="Reservar Cita",h.classList.add("boton"),h.onclick=reservarCita,e.appendChild(i),e.appendChild(p),e.appendChild(v),e.appendChild(h)}async function reservarCita(){const{nombre:e,fecha:t,hora:o,servicios:a,id:n}=cita,c=a.map(e=>e.id),r=new FormData;r.append("fecha",t),r.append("hora",o),r.append("usuarioId",n),r.append("servicios",c);const i=(new Date).toLocaleString("es-EC",{timeZone:"America/Guayaquil",day:"2-digit",month:"2-digit",year:"numeric",hour:"2-digit",minute:"2-digit",second:"2-digit"}),s=i.split(" ")[0].split("/").reverse().join("-").replace(/,/g,"")+" "+i.split(" ")[1];r.append("createdAt",s),r.append("updatedAt",s);try{const e=location.origin+"/api/citas",t=await fetch(e,{method:"POST",body:r});(await t.json()).resultado&&Swal.fire({icon:"success",title:"Cita Reservada!",text:"Se ha reservado la cita correctamente!",button:"Ok"}).then(()=>{window.location.reload()})}catch(e){Swal.fire({icon:"error",title:"Error!",text:"Hubo un error al reservar la cita, intenta de nuevo!"})}}document.addEventListener("DOMContentLoaded",()=>{iniciarApp()});