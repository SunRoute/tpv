<?php

    require_once 'app/Controllers/TableController.php';

    use app\Controllers\TableController;

    $mesa = new TableController();
    $mesas = $mesa->index();

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>diseño tpv</title>
</head>

<body>
    
    <ul>
        <?php foreach($mesas as $mesa):?>
            <?php if( $mesa['estado'] == 1): ?> 
                <li style="background-color: green;">
                </li>
            <?php else: ?>
                <li style="background-color: red;"><?= $mesa['numero']; ?></li>
            <?php endif; ?>
        <?php endforeach;?>
    </ul>
   

</body>

</html>