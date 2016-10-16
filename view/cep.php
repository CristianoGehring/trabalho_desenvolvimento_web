<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="API Correios">
    <meta name="author" content="">
    <link rel="icon" href="../include/bootstrap/img/ico_correios.png">

    <title>API Correios</title>

    <!-- Bootstrap core CSS -->
    <link href="../include/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">
        <h1>CEP</h1>

        <?php
        if (isset($_GET['resposta'])) 
        {
            $resposta = unserialize($_GET['resposta']);

            if(isset($resposta->erro)){
                echo "<p>$resposta->erro<p>";
            }else{
                echo "<table class='table table-condensed table-striped' style='width: 1000px; background-color: #81DAF5;'>"
                    . "<thead>"
                        . "<th> CEP </th>"
                        . "<th> Cidade </th>"
                        . "<th> Endereço </th>"
                        . "<th> Complemento </th>"
                        . "<th> UF </th>"
                    . "</thead>"
                    . "<tbody>"
                        . "<td> $resposta->cep </td>"
                        . "<td> $resposta->cidade </td>"
                        . "<td> $resposta->end </td>"
                        . "<td> $resposta->complemento2 </td>"
                        . "<td> $resposta->uf </td>"
                    . "</tbody>"
                . "</table>";
            }
        }
        ?>

        <div>
            <a href="../view/correios.php" class="btn btn-primary">Voltar</a>
        </div>

    </div>
      
  </body>
</html>
