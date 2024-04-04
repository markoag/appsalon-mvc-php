<h1 class="nombre-pagina">Olvidé mi contraseña</h1>
<p class="descripcion-pagina">Recupera tu contraseña fácilmente</p>

<?php
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/olvidar">
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Tu E-mail">
    </div>

    <input type="submit" value="Recuperar Contraseña" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿No tienes cuenta? Regístrate</a>
</div>