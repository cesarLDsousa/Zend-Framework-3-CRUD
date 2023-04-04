<?php

namespace Blog;
use PHPUnit\Framework\MockObject\Invokable;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            //lista de controllers --> precisam ser registrados
            //Controller\IndexController::class => InvokableFactory::class
        ]
    ],

    'router' => [
        //rota estatica (literal)
        'routes' => [
            'blog' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/blog',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index'
                    ]
                ]
            ],
            'post' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/blog[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index'                    
                    ]
                ]
            ]
        ]
    ],    

    'view_manager' => [
        //carrega pasta das views desse modulo
        'template_path_stack' => [
            //onde procurar as views
            'blog' => __DIR__. '/../view'
        ]
    ]
];