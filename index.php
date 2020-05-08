<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/style.css">
        <title>Sistema de Cadastro</title>
    </head>
    <body>
        <?php
            session_start();
            date_default_timezone_set("America/Sao_Paulo");

            if(isset($_POST["cadastrar"])){
                $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
                $email = $_POST["email"];
                $senha = $_POST["senha"];
                $senhaCripto = md5($senha);
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    if($file=fopen("cadastros.txt", "r")){
                        while($linha=fgets($file)){
                            $linhas[]=explode("|", $linha);
                            foreach ($linhas as $info){
                                if($email==$info[0]){
                                    $repeatedEmail=true;
                                }
                            }
                        }
                    }
                    if(!isset($repeatedEmail)){
                        if($file=fopen("cadastros.txt", "a")){
                            if(fwrite($file, "$email|$senhaCripto|$nome\r\n")){
                                $_SESSION["logado"]=true;
                                $_SESSION["criada"]=true;
                                header("location:index.php");
                            }
                            fclose($file);
                        }
                    }else{
                        echo('<p id="error">Email já cadastrado</p>');
                    }
                }
            }

            if(isset($_POST["logar"])){
                //Abrir arquivo
                if($file=fopen("cadastros.txt", "r")){
                    while($linha=fgets($file)){
                        //salva as informações do arquivo em um array
                        $linhas[]=explode("|", $linha);
                    }
                    $credencial=$_POST["credencial"];
                    $senhaL=$_POST["senhaL"];
                    $senhaCriptoL = md5($senhaL);
                    //Percorre e compara os itens recolhidos do arquivo
                    foreach ($linhas as $info){
                        if($credencial==$info[0]&&$senhaCriptoL==$info[1]){
                            $_SESSION["logado"]=true;
                            header("location:index.php");
                        }else{
                            if($senhaCriptoL==$info[1]){
                                echo("Email incorreto");
                            }else if($credencial==$info[0]){
                                echo("Senha incorreta");
                            }else{
                                echo("Email e Senha incorretos");
                            }
                        }
                    }
                }
            }

            if(isset($_POST["sair"])){
                unset($_SESSION["logado"]);
                unset($_SESSION["criada"]);
            }

            if(!isset($_SESSION["logado"])){
        ?>
        
        <form action="index.php" method="post" id="cadastrar">
            <input type="email" name="email" placeholder="E-MAIL" required></input>
            <input type="password" name="senha" placeholder="SENHA" required></input>
            <button type="submit" name="cadastrar" value="cadastrar">CADASTRAR</button>
        </form>

        <div class="row"><p class="goTo">Já tem uma conta? Entre clicando <a href="logar.php">aqui</a></p></div>

        <?php
            }

                if(isset($_SESSION["criada"])){
        ?>  
            <p id="criada">Conta Criada</p><br>
        <?php
                }

            if(isset($_SESSION["logado"])){
        ?>
            <p id="welcome">Bem Vindo!</p>
            <form action="index.php" method="post" id="deslogar">
                <button type="submit" name="sair" value="sair" id="leave" class="col-4">SAIR</button>
            </form>
        <?php
            }
        ?>
        
    </body>
</html>