<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu Nuevo Password a Continuación</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<!-- Si hay un token no valido oculta la vista-->
<?php if($error) return; ?>

<form method="POST" class="formulario">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu Nuevo Password">
    </div>
    <input type="submit" value="Guardar Nuevo Password" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya Tienes Cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes Cuenta? Obtener Una</a>
</div>