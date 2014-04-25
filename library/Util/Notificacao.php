<?php

/**
 * Classe utilit�ria respons�vel pelo registro de notifica��es
 *
 * @author Gustavo
 */
class Util_Notificacao {
    
    /**
     * Conte�do a ser renderizado pela p�gina
     * @var string
     */
    private static $script = "";
    
    /**
     * Adiciona uma mensagem � sess�o
     * @param string $msg
     * @param string $tipo Criticidade da informa��o
     */
    static function adicionarMensagem($msg, $tipo = 'information') {
         $dataSession = new Zend_Session_Namespace('notificacao');
         $arrMsg = array(
                        'mensagem' => $msg,
                        'tipo' => $tipo
                   );
         $dataSession->data[] = $arrMsg;
    }
    
    /**
     * Exibe as mensagens salvas na sess�o
     */
    static function exibir() {
        //Recupera as mensagens da sess�o e gera o javascript de exibi��o
        $dataSession = new Zend_Session_Namespace('notificacao');
        if( count($dataSession->data) ) {
            foreach( $dataSession->data as $msg ){
                self::gerarScript($msg);
            }
        }
        
        //Limpa a sess�o
        $dataSession->unsetAll();
        
        //Renderiza o conte�do
        self::render();
    }
    
    /**
     * Gera o comando em javascript que exibir� as mensagens
     * @param array $msg
     */
    private static function gerarScript($msg) {
        self::$script .= "setNotification('{$msg['mensagem']}', '{$msg['tipo']}');\n";
    }
    
    /**
     * Renderiza o javascript na tela
     */
    private static function render() {
        echo "<script>";
        echo self::$script;
        echo "</script>";
    }
    
}

?>
