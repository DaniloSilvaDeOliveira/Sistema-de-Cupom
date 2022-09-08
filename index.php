<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cupomania</title>
</head>
<body>
    <div class="cadastrar-button">
        <a href="cadastrar.php">Cadastrar Cupom</a>
    </div>
    <main>
        <form class="form" action="index.php" method="POST">
            <h1>Cupomania</h1>
            <input type="text" placeholder="Digite o código do cupom" name="cupom">
            <input type="submit" value="ativar cupom">
            </form>
        <?php
        if(isset($_POST['cupom'])){
            $cupom = $_POST['cupom'];
            //tenta fazer a conexão
            try{
                $pdo = new PDO('mysql:host=localhost;dbname=cupons','root', '');
                // Defina o modo de erro PDO para exceção
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                die("ERROR: Não foi possível conectar. " . $e->getMessage());
            }

            if(isset($_POST['ativar'])){
                try{
                    $pdo = new PDO('mysql:host=localhost;dbname=cupons','root', '');
                    // Defina o modo de erro PDO para exceção
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch(PDOException $e){
                    die("ERROR: Não foi possível conectar. " . $e->getMessage());
                }
                $query = $pdo->prepare(("UPDATE Cupons SET Estado = '1' WHERE Nome_Cupom = :cupom"));
                $query->bindParam(":cupom",$cupom,PDO::PARAM_STR);
                $query->execute();
                header('index.php');
            }
            
            //faz a requisição
            $query = $pdo->prepare("SELECT * FROM cupons WHERE Nome_Cupom =:cupom");
            $query->bindParam(":cupom",$cupom,PDO::PARAM_STR);
            $query->execute();
            $resultados = $query->fetch(PDO::FETCH_ASSOC);
            
            if($resultados == false){
                echo '<div class="msg">Não foi encontrado nenhum cupom</div>';
            }else{
                echo '<div class="msg">'.$resultados['Comentário'];
                
                if($resultados['Estado'] == 1){
                    echo '<label class="msg-estado-ativado">o item já está ativado!</label>';
                }else{
                    echo '<form method="POST" action="index.php">';
                    echo '<div class="msg-button">';
                    echo '<input value="ATIVAR" name="ativar" type="submit" >';
                    echo '<input value="'.$cupom.'" type="hidden" name="cupom">';
                    echo '</div>';
                    echo '</form>';
                }
                echo '</div>';
            }
        }
        ?>
    
    </main>
</body>
</html>