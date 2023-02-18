<h2 class="nombre-pagina">¿Olvidaste tu contraseña?</h2>
<p class="descripcion-pagina">Reestablece tu contraseña escribiendo tu correo electronico a continuacion</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email" 
            name="email"
            id="email"
            placeholder="Tu Email"
        />
    </div>
    <input class="boton" type="submit" value="Recuperar Contraseña">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Registrate aqui</a>
</div>