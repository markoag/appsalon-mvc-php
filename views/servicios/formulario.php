<fieldset>
    <legend>Informacion Servicio</legend>
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="Nombre del Servicio" name="nombre"
            value="<?php echo s($servicio->nombre); ?>">
    </div>
    <div class="campo">
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion"
            maxlength="200"><?php echo s($servicio->descripcion); ?></textarea>
    </div>
    <div class="campo">
        <label for="precio">Precio</label>
        <input type="number" id="precio" placeholder="Precio del Servicio" name="precio"
            value="<?php echo s($servicio->precio); ?>">
    </div>
</fieldset>