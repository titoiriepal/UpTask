<div class="contenedor login">
    <h1 class="uptask">UpTask</h1>
    <p class="tagline">Crea y Administra tus proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <form class="formulario" method="POST" action="/">
            <div class="campo">
                <label for="email">Email: </label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"                
                />
            </div>

            <div class="campo">
                <label for="password">Password: </label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tu Password"
                    name="password"                
                />
            </div>

            <input type="submit" class="boton" value="Iniciar Sesion">

        </form>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? Obtener una</a>
            <a href="/olvide">¿Olvidaste tu password?</a>
        </div>
     </div> <!--Contenedor-sm -->
</div>