<?php

namespace Product;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * 商品モジュールクラス。
 * ModuleManager はProduct\Moduleクラスを探し、自動的に getConfig() を呼び出す。
 */
class Module implements ConfigProviderInterface
{
    /**
     * ModuleManagerが、自動的に getConfig() を呼び出す。
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * ServiceManager に渡す前に ModuleManager によってすべてマージされたfactoriesの配列を返す。
     *
     * @return array ModuleManager によってすべてマージされたfactoriesの配列
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                // ServiceManager を使用して Product\Model\ProductTableGateway サービスを作成し、そのコンストラクタに渡す。
                Model\ProductTable::class => function ($container) {
                    $tableGateway = $container->get(Model\ProductTableGateway::class);
                    return new Model\ProductTable($tableGateway);
                },
                // ProductTableGateway サービスが Zend\Db\Adapter\AdapterInterface の実装（これも ServiceManager から）を取得し、
                // それを使用して TableGateway オブジェクトを作成することによって作成されることを ServiceManager に伝える。
                // TableGateway クラスは、結果セットとエンティティの作成にプロトタイプ・パターンを使用する。
                // (必要なときにインスタンスを作成するのではなく、 以前にインスタンス化されたオブジェクトをクローンする)
                Model\ProductTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Product());
                    return new TableGateway('products', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    /**
     * Product コントローラのファクトリ
     * (Productコントローラが ProductTable に依存するようになったため必要)
     *
     * @return array
     */
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ProductController::class => function ($container) {
                    return new Controller\ProductController(
                        $container->get(Model\ProductTable::class)
                    );
                },
            ],
        ];
    }
}
