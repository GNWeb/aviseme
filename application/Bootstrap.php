<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    public function _initAutoloader() {
        // Create an resource autoloader component
        $autoloader = new Zend_Loader_Autoloader_Resource(array(
            'basePath' => APPLICATION_PATH,
            'namespace' => ''
        ));

        // Add some resources types
        $autoloader->addResourceTypes(array(
            'models' => array(
                'path' => 'models',
                'namespace' => 'Model'
            ),
            'business' => array(
                'path' => 'business',
                'namespace' => 'Business'
            )
        ));
        
        // Adiciona o diretorio de helpers
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH .'/controllers/helpers');

        // Return to bootstrap resource registry
        return $autoloader;
    }

    /**
     * _initHelpers
     *
     * @desc Sets alternative ways to helpers
     */
    protected function _initHelpers() {
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->initView();
        
        // add zend action helper path
        Zend_Controller_Action_HelperBroker::addPath('application/controllers/helpers/');
    }

}

