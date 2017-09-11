<?php
file_put_contents("c:/testZend33.txt", realpath(__DIR__). '/../view');

return array(
    'controllers' => array(
        'invokables' => array(
            // declaration des controllers
            'Cards\Controller\Cards' => 'Cards\Controller\CardsController'
        ),
    ),
	'router' => array(
        'routes' => array(
            // declaration des routes 
			'cards' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/cards[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',        
                    ), 
                    'defaults' => array(
                        'controller' => 'Cards\Controller\Cards',
                        'action'     => 'index',
                    ),
                ), 
            ),
        ), 
    ),     
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'cards/cards/index' 	  => __DIR__ . '/../view/cards/cards/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);