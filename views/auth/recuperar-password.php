<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Coloca tu nueva contraseña a continuación</p>

<?php
include_once __DIR__ . "/../templates/alertas.php";
?>

<?php if ($error)
    return ?>

<?php if (!$resultado): ?>
    <form class="formulario" method="POST">
        <div class="campo">

            <label for="password">Nueva Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Tu nueva contraseña" required>

        </div>

        <input type="submit" class="boton" value="Recuperar Contraseña">

    </form>
    <div class="acciones">
        <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
        <a href="/crear-cuenta">¿Aún no tienes cuenta? Crea una</a>
    </div>
<?php else: ?>
    <div class="acciones">
        <a href="/">Iniciar Sesión</a>
    </div>
<?php endif; ?>