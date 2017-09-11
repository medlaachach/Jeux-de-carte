<?php

return array(
    'modules' => array(
		'Zend\Router',
        'Zend\Validator',
        //'Application',
        'Cards'
        ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor'
            ),
        'config_glob_paths' => array('config/autoload/{,*.}{global,local}.php')
        )
    );
	
	