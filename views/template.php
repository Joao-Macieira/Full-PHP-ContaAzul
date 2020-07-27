<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <title>Painel - <?php echo $viewData['company_name'] ?></title>
</head>
<body>
   
    <div class="leftmenu">
        <div class="company_name">
        <?php echo $viewData['company_name'] ?>
        </div>
        <div class="menuarea">
            <ul>
                <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>permissions">Permissões</a></li>
                <li><a href="<?php echo BASE_URL; ?>users">Usuários</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="top">
            
            <div class="top_right">
                <a href="<?php echo BASE_URL; ?>login/logout">Sair</a>
            </div>
            <div class="top_right">
                <?php echo $viewData['user_email']; ?>
            </div>

        </div>
        <div class="area">
        <?php $this->loadViewInTemplate($viewName, $viewData); ?>
    </div> 
    </div>
       

    <script src="<?php echo BASE_URL; ?>/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
</body>
</html>