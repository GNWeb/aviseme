<?php

/**
 * Classe para envio de Sms
 *
 * @author Gustavo
 */
class Zend_Controller_Action_Helper_Sms extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Define qual o servi�o est� ativo
     */
    private $servico = 'SMSLEGAL';
    
    /**
     * Usu�rio para a autentica��o
     * @var int 
     */
    private $usuario;
    
    /**
     * Senha para a autentica��o
     * @var string
     */
    private $senha;
    
    /**
     * Destino da mensagem
     * @var int
     */
    private $destinatario;
    
    /**
     * Texto do sms
     * @var string
     */
    private $mensagem;
    
    /**
     * Array com as configura��es dos servi�os
     * @var array
     */
    private $config = array(
        "SMSLEGAL" => array (
            'usuario' => 'terhacker',
            'senha' => '977289',
            'url_envio' => 'http://smsmarketing.smslegal.com.br/index.php?app=webservices&',
            'status' => array (
                'OK' => 'Mensagem Enviada com Sucesso',
                'ERR 100' => 'Falha na Autentica��o do Usu�rio',
                'ERR 101' => 'Tipo de A��o Inv�lida',
                'ERR 102' => 'Um ou mais campos est�o em branco',
                'ERR 200' => 'Entre em contato com nosso Suporte suporte@portaldosms.com',
                'ERR 201' => 'N�mero do Celular de Destino est� em branco',
                'ERR 400' => 'Status da Entrega n�o recuperado'
            )
        )
    );
    
    public function __construct() {
        $this->usuario = $this->config[$this->servico]['usuario'];
        $this->senha = $this->config[$this->servico]['senha'];
    }
            
    /**
     * Chamada direta
     * @return \Zend_Controller_Action_Helper_Util
     */
    public function direct() {
        return $this;
    }
    
    /**
     * Envia a mensagem para o destinat�rio
     * @param string $mensagem
     * @param int $destinatario
     */
    public function enviar($mensagem, $destinatario) {
        $this->mensagem = $mensagem;
        $this->destinatario = $destinatario;
        $url = $this->gerarUrlEnvio();
        
        $resposta = file_get_contents($url);
        return $this->tratarResposta($resposta, $url);
    }

    /**
     * Monta a url de envio de acordo com cada tipo de servi�o
     */
    public function gerarUrlEnvio() {
        switch ($this->servico) {
            case 'SMSLEGAL':
                $params  = 'u='.rawurlencode($this->usuario);
                $params .= '&p='.rawurlencode($this->senha);
                $params .= '&ta=pv&to='.rawurlencode($this->destinatario);
                $params .= '&msg='.rawurlencode($this->mensagem);

                break;

            default:
                break;
        }
        
        return $this->config[$this->servico]['url_envio'] . $params;
    }
    
    /**
     * Interpreta a resposta enviada pelo servi�o
     * @param string $resp
     * @param string $url
     */
    public function tratarResposta($resp, $url) {
        $listaStatus = $this->config[$this->servico]['status'];
        foreach( $listaStatus as $key=>$status ) {
            if(strpos($resp, 'OK')) {
                return true;
            }
            if(strpos($resp, $key)) {
                throw new Exception($status . "\n" . "Url: " . $url);
            }
        }
        
        return false;
    }
}

?>
