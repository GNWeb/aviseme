<?php

class IndexController extends Zend_Controller_Action
{

    /**
     * Tela incial com o formul�rio de cadastro
     */
    public function indexAction()
    {
        //Recupera os dados da sess�o e mant�m o formul�rio preenchido
        $this->_helper->util()->populateSession('cadastro');
        $dataForm = $this->_helper->util()->getDataSession('cadastro');
        if ($dataForm) {
            $this->view->dataForm = $dataForm;
        }
                
        $this->renderScript('usuario/pre-cadastro.phtml');
    }

}

