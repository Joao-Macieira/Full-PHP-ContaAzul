<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css">
    <title>Login</title>
</head>
<body>
    
    <div class="loginArea">
        <form method="post">

            <input type="email" name="email" placeholder="E-mail">

            <input type="password" name="password" placeholder="********">

            <input type="submit" value="Entrar"><br>

            <?php if(isset($error) && !empty($error)): ?>

                <div class="warning"><?php echo $error; ?></div>

            <?php endif; ?>
        </form>
    </div>

</body>
</html>