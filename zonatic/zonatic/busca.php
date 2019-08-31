<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paginación</title>
    
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<?php
        include_once 'paginas.php';

        $articulo = new Articulo(3);        
?>
    <div id="container">
        <?php
            echo $articulo->mostrarTotalResultados() . " resultados totales <br/>";
        ?>

        <div id="paginas">
            <?php
                $articulo->mostrarPaginas();
            ?>
        </div>

        <div id="articulo">
        <?php
            $articulo->mostrarArticulo();
        ?>
        </div>

    </div>
    
</body>
</html>