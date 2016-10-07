<?php
	function rastrearObjeto( $__codigo )
{
    //@var string - URL dos correios para obter dados
    $__wsdl = "http://webservice.correios.com.br/service/rastro/Rastro.wsdl";

    //@var array - a ser usado com parametro para 1 objeto
    $_buscaEventos = array(
        'usuario'   => 'ECT',
        'senha'     => 'SRO',
        'tipo'      => 'L',
        'resultado' => 'T',
        'lingua'    => '101'
    );
    $_buscaEventos['objetos'] = $__codigo;

    // criando objeto soap a partir da URL
    $client = new SoapClient( $__wsdl );
    $r = $client->buscaEventos( $_buscaEventos );

    // sempre retorna objeto por padrao
    return $r->return->objeto;
}

// rastreando um objeto teste hipotetico
$objeto = rastrearObjeto( 'PN020936192BR' );

if(! isset( $objeto->erro ) ){
	foreach ($objeto->evento as $e){
		var_dump( $e );
	}
}else{
	echo $objeto->numero . ": ". $objeto->erro;
}