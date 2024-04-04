document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();    
});

function iniciarApp() {
    buscarPorFechas();
}

function buscarPorFechas() {
    const fechaInicio = document.querySelector('#fechaini');
    // const fechaFin = document.querySelector('#fechafin');
    
    fechaInicio.addEventListener('input', (e) => {
        const fecha1 = e.target.value;        
        window.location = `?fechaini=${fecha1}`;
        
    });
    // fechaFin.addEventListener('input', (e) => {
    //     const fecha2 = e.target.value;        
    //     window.location += `&?fechaini=${fecha2}`;
    // });
}