<?php

    /**
     * Helper responsável pela barra de progresso do cadastro
     */
    class Zend_View_Helper_StepBar extends Zend_View_Helper_Abstract {
        
        /**
         * Construtor
         */
        public function StepBar() {
            echo $this->view->render("helpers/stepBar.phtml");
        }
    }

?>