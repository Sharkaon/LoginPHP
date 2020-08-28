<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/style.css">
        <title>Sistema de Login</title>
    </head>
    <body>
        <form action="index.php" method="post" id="login">
            <input type="email" name="credencial" placeholder="E-MAIL" required></input>
            <input type="password" name="senhaL" placeholder="SENHA" required></input>
            <button type="submit" name="logar" value="logar">ENTRAR</button>
        </form>

        <div class="row"><p class="goTo">Quer criar uma nova conta? Clique <a href="index.php">aqui</a></p></div>
    </body>
</html>