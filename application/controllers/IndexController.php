<?php

class IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $this->_helper->util()->populateSession('cadastro');
        $dataForm = $this->_helper->util()->getDataSession('cadastro');
        if ($dataForm) {
            $this->view->dataForm = $dataForm;
        }
        
        $this->renderScript('usuario/pre-cadastro.phtml');
    }

}

