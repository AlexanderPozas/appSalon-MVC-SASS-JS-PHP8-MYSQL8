<h1 class="nombre-pagina">Olvido Password</h1>
<p class="descripcion-pagina">Reestablece tu Password Escribiendo tu Email a continuación</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form method="POST" action="/forgot" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email" 
            name="email" 
            id="email"
            placeholder="Tu Email"
        >
    </div>
    <input type="submit" value="Enviar Instrucciones" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya Tienes Cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes cuenta? Crear una</a>
</div>