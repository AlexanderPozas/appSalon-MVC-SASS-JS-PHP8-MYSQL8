<h1 class="nombre-pagina">Panel de Administración</h1>
<p class="descripcion-pagina">Listado de las Citas por Día</p>

<?php
@include_once __DIR__ . '/../templates/barra.php';
?>

<h2>Buscar Citas</h2>

<form class="formulario">
    <div class="campo">
        <label for="fecha">Fecha</label>
        <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
    </div>
</form>

<?php
/**Revisa si un array tiene elementos */
    if(count($citas) === 0):
?>
    <h2>No Hay Citas en esta Fecha</h2>
<?php
    endif;
?>

<div id="citas-admin">
    <ul class="citas">
        <?php
            $citaId = 0;
            foreach ($citas as $key => $cita) :
            if ($citaId != $cita->id) :
                $total = 0;
        ?>
        <li>
            <p>Id: <span><?php echo $cita->id; ?></span></p>
            <p>Hora: <span><?php echo $cita->hora; ?></span></p>
            <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
            <p>Email: <span><?php echo $cita->email; ?></span></p>
            <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>
            <h3>Servicios</h3>
            <?php
                $citaId = $cita->id;
                endif;
            ?>
            <p class="servicio"><?php echo $cita->servicio; ?> <span><?php echo $cita->precio; ?></span></p>
            <?php 
                $total += $cita->precio;
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;
                if(esUltimo($actual, $proximo)):
            ?>
            <p class="total">Total: <span><?php echo $total; ?></span></p>
            <form action="/api/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                <input type="submit" value="Eliminar" class="boton-eliminar">
            </form>
            <?php
                endif;
                endforeach;
            ?>
    </ul>
</div>

<?php
    $script = "<script src= '/build/js/buscador.js'></script>";
?>