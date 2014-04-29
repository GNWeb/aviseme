<?php

class IndexController extends Zend_Controller_Action
{

    /**
     * Tela incial com o formulário de cadastro
     */
    public function indexAction()
    {
        //Recupera os dados da sessão e mantém o formulário preenchido
        $this->_helper->util()->populateSession('cadastro');
        $dataForm = $this->_helper->util()->getDataSession('cadastro');
        if ($dataForm) {
            $this->view->dataForm = $dataForm;
        }
                
        $this->renderScript('usuario/pre-cadastro.phtml');
    }

}

