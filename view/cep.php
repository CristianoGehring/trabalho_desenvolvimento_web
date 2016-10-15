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

      <h1>Resultado</h1><p>
            <?php
            if (isset($_GET['resposta'])) 
            {
                //print_r($_GET['resposta']);
                $resposta = unserialize($_GET['resposta']);
                echo "<table class='table table-condensed table-striped' style='width: 700px; background-color: #81DAF5;'>"
                        . "<thead>"
                            . "<th> CEP </th>"
                            . "<th> Cidade </th>"
                            . "<th> Complemento </th>"
                            . "<th> UF </th>"
                        . "</thead>"
                        . "<tbody>"
                            . "<td> $resposta->cep </td>"
                            . "<td> $resposta->cidade </td>"
                            . "<td> $resposta->complemento2 </td>"
                            . "<td> $resposta->uf </td>"
                        . "</tbody>"
                    . "</table>";
                //print_r($resposta);
            }
            ?>

           <h4><a href="../view/correios.php">Retornar</a></h4>

    </div>
  </body>
</html>
