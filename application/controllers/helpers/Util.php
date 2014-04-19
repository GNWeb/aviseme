<?php

/**
 * Classe de utilidades
 *
 * @author Gustavo
 */
class Zend_Controller_Action_Helper_Util extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Chamada direta
     * @return \Zend_Controller_Action_Helper_Util
     */
    public function direct() {
        return $this;
    }

    /**
     * Recupera os dados da sess�o
     * @param string $name Nome da sess�o
     */
    public function getDataSession($name) {
        $dataSession = new Zend_Session_Namespace($name);
        if (isset($dataSession->data)) {
            return $dataSession->data;
        } else {
            return false;
        }
    }
    
    /**
     * Popula a sess�o com os dados que est�o sendo preenchidos dentro do fluxo
     * de cadastro
     * @param string $name Nome da sess�o
     */
    public function populateSession($name) {
        $dataSession = new Zend_Session_Namespace($name);
        if (!isset($dataSession->data)) {
            $dataSession->data = array();
        }
        foreach( $_POST as $key=>$val ) {
            $dataSession->data[$key] = $val;
        }
    }
}

?>
