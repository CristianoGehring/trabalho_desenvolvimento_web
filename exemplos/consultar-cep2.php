<?php
	if (isset($_GET['cep'])) {
		$cep = filter_input(INPUT_GET, 'cep');

		if (empty($cep)) {
			echo 'Informe o CEP';
		} else {
			$config = array(
		        "trace" => 1, 
		        "exception" => 0, 
		        "cache_wsdl" => WSDL_CACHE_MEMORY
		    );
			//http://www.corporativo.correios.com.br/encomendas/sigepweb/doc/Manual_de_Implementacao_do_Web_Service_SIGEPWEB_Logistica_Reversa.pdf
		    $address = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl';   

		    //$client = new SoapClient($address, $config);
		    $client = new SoapClient($address);

		    try
			{
			    $cep  = $client->consultaCEP(['cep' => $cep]);
			    var_dump($cep);
			}
			catch(Exception $e) 
			{
			    var_dump($e);
			}
		}
	}
?>