
<?php include_once __DIR__ . '/header_dashboard.php'; ?>

    <div class="contenedor-sm">
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
        <form class="formulario" method="POST" action="/crear-proyecto">

            <?php include_once __DIR__ . '/formulario-proyecto.php'; ?>
            <input type="submit" value="Crear proyecto">


        </form>

    </div>


<?php include_once __DIR__ . '/footer_dashboard.php'; ?>