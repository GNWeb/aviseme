<?php

    /**
     * Helper responsável pela barra lateral direita
     */
    class Zend_View_Helper_ColRight extends Zend_View_Helper_Abstract {
        
        /**
         * Construtor
         */
        public function ColRight() {
            echo $this->view->render("helpers/colRight.phtml");
        }
    }

?>