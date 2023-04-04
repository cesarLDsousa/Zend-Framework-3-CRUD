<?php 

namespace Blog;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;


class Module implements ConfigProviderInterface
{
    public function getConfig() //metodo carregado automaticamente --> arquivo config
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            //registro de serviços
            'factories' => [
                Model\PostTable::class => function ($container) {
                    $tableGateway = $container->get(Model\PostTableGateway::class);
                    return new Model\PostTable($tableGateway);
                },
                Model\PostTableGateway::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->getArrayObjectPrototype(new Model\Post);
                    return new TableGateway('post', $dbAdapter, null, $resultSetPrototype);
                },
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\IndexController::class => function($container) {
                    return new Controller\IndexController(
                        $container->get(Model\PostTable::class)
                    );
                }
            ]
        ];
    }
}