<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" action="/" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email" 
            name="email"
            id="email"
            placeholder="Tu Email"
        />
    </div>
    <div class="campo">
        <label for="password">Constraseña</label>
        <input 
        type="password"
        name="password"
        id="password"
        placeholder="Tu Contraseña"
        autocomplete=""       
        />
    </div>

    <input class="boton" type="submit" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Registrate aqui</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>