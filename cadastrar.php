<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cupons</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="cadastrar-button">
        <a href="index.php">Página Inicial</a>
    </div>
    <main>
        <form class="form-cadastro" action="cadastrar.php" method="post">
            <h1>Cadastrar Cupons</h1>
            <input type="text" name="nomeCupom" placeholder="Código do Cupom">
            <input type="text" name="comentario" placeholder="O que o cupom oferece?">
            <input type="submit" name="Cad" value="Cadastrar">
            <?php
                if(isset($_POST['Cad'])){
                    $cupom = $_POST['nomeCupom'];
                    $comentario = $_POST['comentario'];
                    //tenta fazer a conexão
                    try{
                        $pdo = new PDO('mysql:host=localhost;dbname=cupons','root', '');
                        // Defina o modo de erro PDO para exceção
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch(PDOException $e){
                        die("ERROR: Não foi possível conectar. " . $e->getMessage());
                    }
                    $query = $pdo->prepare("INSERT INTO 
                    Cupons(Nome_Cupom, Comentário, Estado)
                    VALUES (:Cupom,:Comentario,0)");
                    $query->bindParam(":Cupom",$cupom,PDO::PARAM_STR);
                    $query->bindParam(":Comentario",$comentario,PDO::PARAM_STR);
                    $query->execute();



                }
        
            ?>
        </form>
    </main>

</body>
</html>