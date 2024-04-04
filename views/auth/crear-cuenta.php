<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Regístrate para poder iniciar sesión</p>

<?php
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" placeholder="Tu Nombre" value="<?php echo s($usuario->nombre); ?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido" placeholder="Tu Apellido"
            value="<?php echo s($usuario->apellido); ?>">
    </div>
    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input type="tel" name="telefono" id="telefono" placeholder="Tu Teléfono"
            value="<?php echo s($usuario->telefono); ?>">
    </div>
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Tu E-mail" value="<?php echo s($usuario->email); ?>">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Tu Contraseña"
            value="<?php echo s($usuario->password); ?>">
    </div>

    <input type="submit" value="Crear Cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
    <a href="/olvidar">¿Olvidaste tu contraseña?</a>
</div>