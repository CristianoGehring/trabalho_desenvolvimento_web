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

      <h1>Rastrear Objeto</h1><p>
            <?php
                        
            function printaAtributo($valor, $atributo)
            {
                if(property_exists($valor, $atributo)){
                    if($atributo=='descricao' && $valor->tipo == 'RO')
                        echo "<td>" . $valor->{$atributo} . " para "
                                . $valor->destino->local . " - " . $valor->destino->cidade . "</td>";                        
                    else
                       echo "<td>" . $valor->{$atributo} . "</td>";
                }
            }

            function mostraResultado($resposta){
                if(isset($resposta->erro)){
                    echo "<p>Códigio de Rastreio: $resposta->numero </p>";
                    echo "<p>Erro: ".utf8_decode($resposta->erro)."<p>";

                }else{
                    echo "Códigio de Rastreio: $resposta->numero<br>";
                    echo "Sigla: $resposta->sigla<br>";
                    echo "Nome: $resposta->nome<br>";
                    echo "Categoria: $resposta->categoria<br>";
                    echo "<table class='table table-condensed table-striped' style='width: 1100px; background-color: #81DAF5;'>"
                        . "<thead>"
                            . "<th> Data </th>"
                            . "<th> Hora </th>"
                            . "<th> Local </th>"
                            . "<th> Cidade </th>"
                            . "<th> UF </th>"
                            . "<th> Descrição </th>"
                            //. "<th> Destino </th>"
                        . "</thead>";
                    foreach ($resposta->evento as $res => $evento) {
                        echo "<tbody>";
                        printaAtributo($evento, 'data');
                        printaAtributo($evento, 'hora');
                        printaAtributo($evento, 'local');
                        printaAtributo($evento, 'cidade');
                        printaAtributo($evento, 'uf');
                        printaAtributo($evento, 'descricao');
                        echo "</tbody>";
                    }
                    echo "</table>";
                }
            }
            
            if (isset($_GET['resposta'])) 
            {
                $resposta = unserialize($_GET['resposta']);
                $resposta = $resposta->objeto;

                if(gettype($resposta) ==  'array'){
                    foreach ($resposta as $key => $res) {
                        mostraResultado($res);
                    }
                }else{
                    mostraResultado($resposta);
                }
            }
            ?>

        <div>
            <a href="../view/correios.php" class="btn btn-primary">Voltar</a>
        </div>
    </div>
  </body>
</html>
