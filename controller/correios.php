<?php
if (isset($_GET['operacao'])) {
	switch ($_GET['operacao']) {
		case 'consultar_cep':
			if (isset($_POST['cep'])) {
				$cep = $_POST['cep'];

				if($cep != ''){
					$cep = preg_replace("/[^0-9]/","", $cep);//retira caracteres que não são digitos
					$resposta = consultarCep($cep);
					$resposta = serialize($resposta);
					header("location:../view/cep.php?resposta=$resposta");
				}
			}
		break;

		case 'rastrear_obj':
			if (isset($_POST['codigo'])) {
				$codigo = $_POST['codigo'];

				if($codigo != ''){
					$resposta = rastrearObjeto($codigo);
					$resposta = serialize($resposta);
					header("location:../view/rastrear.php?resposta=$resposta");
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

			$resposta = calcularFrete($cepOrigem,
			$cepDestino,
			$peso,
			$valor,
			$tipoFrete,
			$altura,
			$largura,
			$comprimento);
			$resposta = serialize($resposta);
			header("location:../view/calcularFrete.php?resposta=$resposta");
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

		return $resposta->return;
	}
	catch(Exception $e) 
	{
		$obj = new StdClass;
		$obj->erro = $e->getMessage();
		return $obj;

	}
}

function rastrearObjeto ($codigo) {
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
		return $resposta->return;
	}
	catch(Exception $e) 
	{
		$obj = new StdClass;
		$obj->numero = $codigo;
		$obj->erro = $e->getMessage();
		return $obj;
	}

}

function calcularFrete($cepOrigem,
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
	$url .= "&sCepOrigem=" . preg_replace("/[^0-9]/","", $cepOrigem);
	$url .= "&sCepDestino=" . preg_replace("/[^0-9]/","", $cepDestino);
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

	//40010 SEDEX Varejo
	//40045 SEDEX a Cobrar Varejo
	//40215 SEDEX 10 Varejo
	//40290 SEDEX Hoje Varejo
	//41106 PAC Varejo
 
	$xml = simplexml_load_file($url);

	$resposta = $xml->cServico;

	$mensagem = '';

	switch ($resposta->Erro) {
		case '0':
			$mensagem = 'Processamento com sucesso';
		break;
		case '-1':
			$mensagem = 'Código de serviço inválido';
		break;
		case '-2':
			$mensagem = 'CEP de origem inválido';
		break;
		case '-3':
			$mensagem = 'CEP de destino inválido';
		break;
		case '-4':
			$mensagem = 'Peso excedido';
		break;
		case '-5':
			$mensagem = 'O Valor Declarado não deve exceder R$ 10.000,00';
		break;
		case '-6':
			$mensagem = 'Serviço indisponível para o trecho informado';
		break;
		case '-7':
			$mensagem = 'O Valor Declarado é obrigatório para este serviço';
		break;
		case '-8':
			$mensagem = 'Este serviço não aceita Mão Própria';
		break;
		case '-9':
			$mensagem = 'Este serviço não aceita Aviso de Recebimento';
		break;
		case '-10':
			$mensagem = 'Precificação indisponível para o trecho informado';
		break;
		case '-11':
			$mensagem = 'Para definição do preço deverão ser informados, também, o comprimento, a largura e altura do objeto em centímetros (cm).';
		break;
		case '-12':
			$mensagem = 'Comprimento inválido.';
		break;
		case '-13':
			$mensagem = 'Largura inválida.';
		break;
		case '-14':
			$mensagem = 'Altura inválida.';
		break;
		case '-15':
			$mensagem = 'O comprimento não pode ser maior que 105 cm.';
		break;
		case '-16':
			$mensagem = 'A largura não pode ser maior que 105 cm.';
		break;
		case '-17':
			$mensagem = 'A altura não pode ser maior que 105 cm.';
		break;
		case '-18':
			$mensagem = 'A altura não pode ser inferior a 2 cm.';
		break;
		case '-20':
			$mensagem = 'A largura não pode ser inferior a 11 cm.';
		break;
		case '-22':
			$mensagem = 'O comprimento não pode ser inferior a 16 cm.';
		break;
		case '-23':
			$mensagem = 'A soma resultante do comprimento + largura + altura não deve superar a 200 cm.';
		break;
		case '-24':
			$mensagem = 'Comprimento inválido.';
		break;
		case '-25':
			$mensagem = 'Diâmetro inválido';
		break;
		case '-26':
			$mensagem =  'Informe o comprimento.';
		break;
		case '-27':
			$mensagem = 'Informe o diâmetro.';
		break;
		case '-28':
			$mensagem = 'O comprimento não pode ser maior que 105 cm.';
		break;
		case '-29':
			$mensagem = 'O diâmetro não pode ser maior que 91 cm.';
		break;
		case '-30':
			$mensagem =  'O comprimento não pode ser inferior a 18 cm.';
		break;
		case '-31':
			$mensagem = 'O diâmetro não pode ser inferior a 5 cm.';
		break;
		case '-32':
			$mensagem = 'A soma resultante do comprimento + o dobro do diâmetro não deve superar a 200 cm.';
		break;
		case '-33':
			$mensagem =  'Sistema temporariamente fora do ar. Favor tentar mais tarde.';
		break;
		case '-34':
			$mensagem = 'Código Administrativo ou Senha inválidos.';
		break;
		case '-35':
			$mensagem = 'Senha incorreta.';
		break;
		case '-36':
			$mensagem =  'Cliente não possui contrato vigente com os Correios.';
		break;
		case '-37':
			$mensagem = 'Cliente não possui serviço ativo em seu contrato.';
		break;
		case '-38':
			$mensagem = 'Serviço indisponível para este código administrativo.';
		break;
		case '-39':
			$mensagem =  'Peso excedido para o formato envelope';
		break;
		case '-40':
			$mensagem = 'Para definicao do preco deverao ser informados, tambem, o comprimento e a largura e altura do objeto em centimetros (cm).';
		break;
		case '-41':
			$mensagem =  'O comprimento nao pode ser maior que 60 cm.';
		break;
		case '-42':
			$mensagem = 'O comprimento nao pode ser inferior a 16 cm.';
		break;
		case '-43':
			$mensagem = 'A soma resultante do comprimento + largura nao deve superar a 120 cm.';
		break;
		case '-44':
			$mensagem =  'A largura nao pode ser inferior a 11 cm.';
		break;
		case '-45':
			$mensagem = 'A largura nao pode ser maior que 60 cm.';
		break;
		case '-888':
			$mensagem = 'Erro ao calcular a tarifa';
		break;
		case '006':
			$mensagem =  'Localidade de origem não abrange o serviço informado';
		break;
		case '007':
			$mensagem = 'Localidade de destino não abrange o serviço informado';
		break;
		case '008':
			$mensagem = 'Serviço indisponível para o trecho informado';
		break;
		case '009':
			$mensagem =  'CEP inicial pertencente a Área de Risco.';
		break;
		case '010':
			$mensagem = 'Área com entrega temporariamente sujeita a prazo diferenciado.';
		break;
		case '011':
			$mensagem = 'CEP inicial e final pertencentes a Área de Risco';
		break;
		case '7':
			$mensagem =  'Serviço indisponível, tente mais tarde';
		break;
		case '99':
			$mensagem = 'Outros erros diversos do .case Net';
		break;

	}
	$resposta->MsgErro = $mensagem;

	$resposta = xml2array($resposta);

	return $resposta;
}

function xml2array ( $xmlObject, $out = array () )//converte xml object para array
{
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}
?>



