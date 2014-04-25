<?php

/**
 * Classe utilitária responsável pelo registro de notificações
 *
 * @author Gustavo
 */
class Util_Notificacao {
    
    /**
     * Conteúdo a ser renderizado pela página
     * @var string
     */
    private static $script = "";
    
    /**
     * Adiciona uma mensagem à sessão
     * @param string $msg
     * @param string $tipo Criticidade da informação
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
     * Exibe as mensagens salvas na sessão
     */
    static function exibir() {
        //Recupera as mensagens da sessão e gera o javascript de exibição
        $dataSession = new Zend_Session_Namespace('notificacao');
        if( count($dataSession->data) ) {
            foreach( $dataSession->data as $msg ){
                self::gerarScript($msg);
            }
        }
        
        //Limpa a sessão
        $dataSession->unsetAll();
        
        //Renderiza o conteúdo
        self::render();
    }
    
    /**
     * Gera o comando em javascript que exibirá as mensagens
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
