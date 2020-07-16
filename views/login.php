<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        form {
            width: 300px;
            height: 300px;
            background-color: #DDD;
            margin: auto;
            margin-top: 30px;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        input {
            width: 250px;
            padding: 15px;
            font-size: 15px;
            border: 1px solid #CCC;
        }


    </style>
    <title>Login - EAD</title>
</head>
<body>

    <form method="POST">
    <h2>Login</h2>
        <input type="email" name="email" placeholder="Email"><br><br>

        <input type="password" name="senha" placeholder="Senha"><br><br>

        <input type="submit" value="Entrar">
    </form>
</body>
</html>
