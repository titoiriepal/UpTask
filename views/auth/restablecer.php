<div class="contenedor restablecer">
    
<?php  include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nuevo Password</p>

        <form class="formulario" method="POST" action="/restablecer">

            <div class="campo">
                <label for="password">Password: </label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tu Password"
                    name="password"                
                />
            </div>

            <input type="submit" class="boton" value="Guardar Password">

        </form>

        <div class="acciones">
            <a href="/">Iniciar Sesión</a>
            <a href="/crear">¿Aún no tienes una cuenta? Obtener una</a>
        </div>
     </div> <!--Contenedor-sm -->
</div>