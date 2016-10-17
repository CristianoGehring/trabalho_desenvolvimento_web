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

      <h1>Resultado</h1>
      <div>
        <?php
          if (isset($_GET['resposta'])) 
          {
            $resposta = unserialize($_GET['resposta']);

            if(isset($resposta->erro)){
                echo "<p>$resposta->erro<p>";
            }else{
                echo "<table class='table table-condensed table-striped' style='width: 1000px; background-color: #81DAF5;'>"
                    . "<thead>"
                        . "<th> Codigo </th>"
                        . "<th> Valor </th>"
                        . "<th> Prazo de Entrega (dias) </th>"
                        . "<th> Entrega Domiciliar </th>"
                        . "<th> Entrega Sabado </th>"
                    . "</thead>"
                    . "<tbody>"
                        . "<td> $resposta->Codigo </td>"
                        . "<td> $resposta->Valor </td>"
                        . "<td> $resposta->PrazoEntrega </td>"
                        . "<td> $resposta->EntregaDomiciliar </td>"
                        . "<td> $resposta->EntregaSabado </td>"
                    . "</tbody>"
                . "</table>";
            }
            echo "<pre>";
            print_r($resposta);
          }
          ?>
      </div>
      <div>
        <a href="../view/correios.php" class="btn btn-primary">Voltar</a>
      </div>

    </div>
  </body>
</html>
