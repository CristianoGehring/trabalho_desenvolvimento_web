<?php
/**
 * Classe utilizada para rastrear pedidos dos correiors via API e XML
 * @autor : Gomes [viniciusllgomes@gmail.com]
 */
class RastrearPedido
{
    /**
     * URL para onde devemos requerir os eventos do produto rastreado
     * @var string
     */
    private $url = "http://websro.correios.com.br/sro_bin/sroii_xml.eventos";
    
    /**
     * Array que guarda infos que serao enviadas ao correio para rastreamento
     * array( Usuario, Senha, Tipo, Resultado, Objetos )
     * @var Array() 
     */
    private $data = array(); 
   
    private $xml = null;
   
    function __construct( $arr_dados = array() )
    {
       // @todo - validar dados recebidos
       if( !empty( $dados ) ) $this->data = $arr_dados;
       else{
          $this->data = array(
             'Usuario' => 'ECT', /* Informado pela área comercial dos Correios na ativação do serviço. */
             'Senha' => 'SRO',   /* Informado pela área comercial dos Correios na ativação do serviço. */
             'Tipo' => 'L',      /* L - Lista de Objetos, F - Intervalo de Objetos */
             'Resultado' => 'T', /* T : Retorna todos os eventos do objeto, U : Retorna apenas ultimo evento do objeto */
             'Objetos' => 'XX000000000YY' /*IDs listadas sem espacos um apos o outro*/  
        );
        }
    }
    /**
    * metodo usado para passar codigo de rastreamento
    * @param string[13] $objetos - codigo do objeto a ser rastreado
    * @return XML
    */
    function rastrear( $objetos = null )
    {
        if( $objetos ) $this->data['Objetos'] = $objetos;
        $this->xml = $this->curl_connection( $this->url, 'POST', $this->data );echo $this->xml;exit;
        return simplexml_Load_string( $this->xml );
    }
    /**
    * Método para conexão via cRUL.
    * @param type $url
    * @param string $method GET com padrão
    * @param array $data
    * @param type $timeout 30
    * @param type $charset ISO
    * @return array
    */
    private function curl_connection(
        $url, 
        $method = 'GET', 
        Array $data = null, 
        $timeout = 30, 
        $charset = 'ISO-8859-1'
    ){  
        if (strtoupper($method) === 'POST') {
            $postFields = ($data ? http_build_query($data, '', '&') : "");
            $contentLength = "Content-length: ".strlen($postFields);
            $methodOptions = Array(
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postFields,
                    );          
        } else {
            $contentLength = null;
            $methodOptions = Array(
                    CURLOPT_HTTPGET => true
                    );              
        }
 
        $options = Array(
            CURLOPT_HTTPHEADER => Array(
                "Content-Type: application/x-www-form-urlencoded; charset=".$charset,
                $contentLength
            ),  
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CONNECTTIMEOUT => $timeout,
            //CURLOPT_TIMEOUT => $timeout
        ); 
        $options = ($options + $methodOptions);
 
        $curl = curl_init();
        curl_setopt_array($curl, $options);         
        $resp  = curl_exec($curl);
        $info  = curl_getinfo($curl);// para debug
        $error = curl_errno($curl);
        $errorMessage = curl_error($curl);
        curl_close($curl);
        
        if ($error) {
            //log_message('error', $errorMessage);
                //throw new Exception("Erro ao conectar: $errorMessage");
                return false;
        } else {
                return $resp;
        }
    }
}

// instanciando Objeto de rastreamento
$obj = new RastrearPedido();

$codigo = 'PN020936192BR';

// passando codigo de rastreamento como parametro
$xml = $obj->rastrear( $codigo );

/*if( isset($obj_xml) && is_object($obj_xml) )
    {
        if( count( $obj_xml->error ) <= 0 )
        {
            echo $obj_xml->qtd . "\n";
            echo $obj_xml->TipoPesquisa . "\n";
            echo $obj_xml->TipoResultado . "\n";
            
            // se for uma lista de objetos percorre a lista
            foreach ( $obj_xml->objeto as $o ):
            
                echo $o->numero . "\n";
                // percore todos os eventos registrados deste objeto
                foreach( $o->evento as $e ):
            
                    // 3 campos que raramente sao preenchidos
                    $recebedor = (!isset($e->recebedor))?' ':$e->recebedor;
                    $documento = (!isset($e->documento))?' ':$e->documento;
                    $comentario = (!isset($e->comentario))?' ':$e->comentario;
                
                    echo "
                            $e->tipo \n
                            $e->sto  \n
                            $e->data \n
                            $e->hora \n
                            $e->descricao \n
                            $recebedor \n
                            $documento \n
                            $comentario \n
                            $e->local \n
                            $e->codigo \n
                            $e->cidade \n
                            $e->uf \n
                            $e->status \n
                        ";
 
                    // se existe node destino entao ...
                    if( count( $e->destino ) > 0 ):
 
                        echo "
                            $e->destino->local \n
                            $e->destino->codigo \n
                            $e->destino->bairro / $e->destino->cidade \n
                            $e->destino->uf \n";
                    endif;          
                
                endforeach;
            endforeach;
                
        }else{
            echo $obj_xml->error;
        }
    }else{
        echo "XML não parece ser um objeto valido.
        Parece que há um problema com o serviço de rastreamento dos Correios.";
    }  */

?>