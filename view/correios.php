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

      <div style="width:300px;">
        <form action="../controller/correios.php?operacao=consultar_cep" method="POST">
          <h2 class="form-signin-heading">Consultar CEP</h2>
          <div class="form-group">
            <input type="text" class="form-control" name="cep" placeholder="Digite o CEP" required>
          </div>
          <input class="btn btn-primary" type="submit" value="Consultar">
        </form>
      </div>

      <div style="width:300px;">
        <form action="../controller/correios.php?operacao=rastrear_obj" method="POST">
          <h2 class="form-signin-heading">Rastrear Objeto</h2>
          <div class="form-group">
            <input type="text" class="form-control" name="codigo" placeholder="Digite o código de rastreio" required>
          </div>
          <input class="btn btn-primary" type="submit" value="Rastrear">
        </form>
      </div>

      <div style="width:300px;">
        <form action="../controller/correios.php?operacao=calcular_frete" method="POST">
          <h2 class="form-signin-heading">Calcular Frete</h2>
          <div class="form-group">
            <input type="text" class="form-control" name="cep_origem" placeholder="Digite o CEP de Origem" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="cep_destino" placeholder="Digite o CEP de Destino" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="peso" placeholder="Digite o Peso" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="valor" placeholder="Digite o Valor do Produto" required>
          </div>
          <div class="form-group">
            <input type="radio" name="tipo_frete" value="40010" checked>Sedex<br>
            <input type="radio" name="tipo_frete" value="40045">Sedex a Cobrar<br>
            <input type="radio" name="tipo_frete" value="40215">Sedex 10<br>
            <input type="radio" name="tipo_frete" value="40290">Sedex Hoje<br>
            <input type="radio" name="tipo_frete" value="41106">PAC
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="altura" placeholder="Digite a Altura" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="largura" placeholder="Digite a Largura" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="comprimento" placeholder="Digite o Comprimento" required>
          </div>
          <input class="btn btn-primary" type="submit" value="Calcular">
        </form>
      </div>

    </div>
  </body>
</html>
