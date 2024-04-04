<h1 class="nombre-pagina">Panel de Admin</h1>

<?php
include_once __DIR__ . '/../templates/barra.php';
?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha Inicio</label>
            <input type="date" id="fechaini" name="fechaini" value="<?php echo $fechaini ?>">

            <!-- <label for="fecha">Fecha Fin</label>
            <input type="date" id="fechafin" name="fechafin" value="<?php //echo $fechafin  ?>"> -->
        </div>
    </form>
</div>

<?php
if (empty($citas)) {
    echo "<h2>No hay citas para esta fecha</h2>";
}
?>

<div id="citas-admin">
    <ul class="citas">
        <?php
        $citaID = 0;
        foreach ($citas as $key => $cita) {
            if ($citaID !== $cita->id) {
                $total = 0;
                ?>
                <li>
                    <p>ID: <span>
                            <?php echo $cita->id; ?>
                        </span></p>
                    <p>Fecha: <span>
                            <?php echo $cita->fecha; ?>
                        </span></p>
                    <p>Hora: <span>
                            <?php echo $cita->hora; ?>
                        </span></p>
                    <p>Cliente: <span>
                            <?php echo $cita->nombre; ?>
                        </span></p>
                    <p>Teléfono: <span>
                            <?php echo $cita->telefono; ?>
                        </span></p>

                    <h3>Servicios</h3>
                    <?php
                    $citaID = $cita->id;
            } // Fin if
            $total += $cita->precio;
            ?>
                <p class="servicio">
                    <?php echo $cita->servicio . "  " . "$" . $cita->precio; ?>
                </p>
                <?php
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;

                if (esUltimo($actual, $proximo)) {
                    ?>
                    <p class="total">Total: <span>
                            <?php echo $total; ?>
                        </span></p>
                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="submit" value="Eliminar" class="boton-eliminar">
                    </form>
                <?php }  // Fin if
        
        } // Fin foreach
        ?>
    </ul>
</div>

<?php
$script = "<script src='/build/js/buscador.js'></script>";
?>