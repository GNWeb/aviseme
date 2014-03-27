<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initAutoloader()
    {
        // Create an resource autoloader component
        $autoloader = new Zend_Loader_Autoloader_Resource(array(
            'basePath'    => APPLICATION_PATH,
            'namespace' => ''
        ));

        // Add some resources types
        $autoloader->addResourceTypes(array(
            'models' => array(
                'path'           => 'models',
                'namespace' => 'Model'    
            ),
            'business' => array(
                'path'           => 'business',
                'namespace' => 'Business'    
            )
        ));

        // Return to bootstrap resource registry
        return $autoloader;
    }
    
}

