<?php
if (isset($_GET['operacao'])) {
	switch ($_GET['operacao']) {
		case 'consultar_cep':
			if (isset($_POST['cep'])) {
				$cep = $_POST['cep'];

				if($cep != ''){
					$cep = preg_replace("/[^0-9]/","", $cep);//retira caracteres que não são digitos
					consultarCep($cep);
				}
			}
			break;

		case 'rastrear_obj':
			if (isset($_POST['codigo'])) {
				$codigo = $_POST['codigo'];

				if($codigo != ''){
					rastrearObj($codigo);
				}
			}
			break;

		case 'calcular_frete':
			$cepOrigem = $_POST['cep_origem'];
			$cepDestino = $_POST['cep_destino'];
		    $peso = $_POST['peso'];
		    $valor = $_POST['valor'];
		    $tipoFrete = $_POST['tipo_frete'];
		    $altura = $_POST['altura'];
		    $largura = $_POST['largura'];
		    $comprimento = $_POST['comprimento'];

			calcular_frete($cepOrigem,
		    $cepDestino,
		    $peso,
		    $valor,
		    $tipoFrete,
		    $altura,
		    $largura,
		    $comprimento);
			break;
		
		default:
			echo utf8_decode("Operação inexistente!");
			break;
	}
}

function consultarCep ($cep) {
	$wsdl = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl';   

	$client = new SoapClient($wsdl);

	$parametros = array(
		'cep' => $cep
	);

    try
	{
	    $resposta = $client->consultaCEP($parametros);
	    echo '<pre>';
	    print_r($resposta);
	}
	catch(Exception $e) 
	{
		echo '<pre>';
	    print_r($e);
	}
}

function rastrearObj ($codigo) {
	$wsdl = "http://webservice.correios.com.br/service/rastro/Rastro.wsdl";

	$parametros = array(
        'usuario'   => 'ECT',
        'senha'     => 'SRO',
        'tipo'      => 'L',
        'resultado' => 'T',
        'lingua'    => '101',
        'objetos'	=> $codigo
    );

    // criando objeto soap a partir da URL
    $client = new SoapClient( $wsdl );

    try
	{
	    $resposta = $client->buscaEventos( $parametros );
	    echo '<pre>';
	    print_r($resposta);
	}
	catch(Exception $e) 
	{
		echo '<pre>';
	    print_r($e);
	}

}

function calcular_frete($cepOrigem,
    $cepDestino,
    $peso,
    $valor,
    $tipoFrete,
    $altura,
    $largura,
    $comprimento){
 
 
    $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
    $url .= "nCdEmpresa=";
    $url .= "&sDsSenha=";
    $url .= "&sCepOrigem=" . $cepOrigem;
    $url .= "&sCepDestino=" . $cepDestino;
    $url .= "&nVlPeso=" . $peso;
    $url .= "&nVlLargura=" . $largura;
    $url .= "&nVlAltura=" . $altura;
    $url .= "&nCdFormato=1";
    $url .= "&nVlComprimento=" . $comprimento;
    $url .= "&sCdMaoProria=n";
    $url .= "&nVlValorDeclarado=" . $valor;
    $url .= "&sCdAvisoRecebimento=n";
    $url .= "&nCdServico=" . $tipoFrete;
    $url .= "&nVlDiametro=0";
    $url .= "&StrRetorno=xml";
 
    //Sedex: 40010
    //Pac: 41106
    //40010 SEDEX Varejo
	//40045 SEDEX a Cobrar Varejo
	//40215 SEDEX 10 Varejo
	//40290 SEDEX Hoje Varejo
	//41106 PAC Varejo
 
    $xml = simplexml_load_file($url);
 
    //return $xml->cServico;
    echo "<pre>";
    print_r($xml);
 
}
?>