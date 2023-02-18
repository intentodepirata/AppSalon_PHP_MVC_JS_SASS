<h1 class="nombre-pagina">Reestablece Tu Password</h1>
<p class="descripcion-pagina">Introduce tu nueva contraseña a continuacion</p>

<?php include_once __DIR__ . '/../templates/alertas.php';?>

<?php if($error) return; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password" 
            name="password"
            id="password"
            placeholder="Tu nuevo password"
           
        />
    </div>

    <input class="boton" type="submit" value="Guardar Nuevo Password">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Registrate aqui</a>
</div>