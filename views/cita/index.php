<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus Servicios y Coloca tus Datos</p>

<?php @include_once __DIR__ . '/../templates/barra.php'; ?>

<div id="app">
    <!--Botones de navegación-->
    <div class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </div>
    <!--Seccion 1 Servicios-->
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus Servicios a Continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <!--Seccion 2 Datos Cita-->
    <div id="paso-2" class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">coloca tus Datos y Fecha de Cita</p>
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu Nombre" value="<?php echo $nombre; ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')) ?>">
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora">
            </div>
            <input type="hidden" id="id" name="usuarioId" value="<?php echo $id; ?>">
        </form>
    </div>

    <!--Seccion 3 Resumen Citaa-->
    <div id="paso-3" class="seccion contenido-resumen">
        <!--Los hijos de este elemento se eliminaran vía JS con removechild-->
        <h1>Resumen de Cita</h1>
    </div>

    <!--Botones Paginacion-->
    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>

</div>

<?php
$script ="<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
<script src='build/js/app.js'></script>
";
?>