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
            
            function printaResultado($valor, $atributo)
            {
                //if($atributo=="endereco")
                if(property_exists($valor, $atributo))
                    echo $valor->{$atributo}."<br>";
            }
            
            if (isset($_GET['resposta'])) 
            {
                 $resposta = unserialize($_GET['resposta']);
                 $resposta = $resposta->objeto;
                 echo "$resposta->numero<br>";
                 echo "$resposta->sigla<br>";
                 echo "$resposta->nome<br>";
                 echo "$resposta->categoria<br>";
                 foreach ($resposta->evento as $res => $evento) {
                     //printaResultado($evento->tipo);
                     /*echo "$evento->status<br>";
                     echo "$evento->data<br>";
                     echo "$evento->hora<br>";
                     echo "$evento->descricao<br>";
                     echo "$evento->recebedor<br>";
                     echo "$evento->documento<br>";
                     echo "$evento->comentario<br>";
                     echo "$evento->local<br>";
                     echo "$evento->codigo<br>";
                     echo "$evento->cidade<br>";
                     echo "$evento->uf<br>";*/
                     printaResultado($evento, 'status');
                     printaResultado($evento, 'data');
                     printaResultado($evento, 'hora');
                     printaResultado($evento, 'descricao');
                     printaResultado($evento, 'recebedor');
                     printaResultado($evento, 'documento');
                     printaResultado($evento, 'comentario');
                     printaResultado($evento, 'local');
                     printaResultado($evento, 'codigo');
                     printaResultado($evento, 'cidade');
                     printaResultado($evento, 'uf');
                 }
                    /*echo "<table class='table table-condensed table-striped' style='width: 700px; background-color: #81DAF5;'>"
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
                    . "</table>";*/
                 echo "<pre>";
                print_r($resposta);
            }
            ?>

           <h4><a href="../view/correios.php">Retornar</a></h4>

    </div>
  </body>
</html>
