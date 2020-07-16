<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <title>EAD</title>
</head>
<body>
    <div class="topo">
        <a href="<?php echo BASE_URL; ?>/login/logout">
            <div>Sair</div>
        </a>
        <div class="topousuario">
           Olá <?php echo $viewData['info']->getNome(); ?>
        </div>
    </div>



    <?php $this->loadViewInTemplate($viewName, $viewData); ?>
</body>
</html>