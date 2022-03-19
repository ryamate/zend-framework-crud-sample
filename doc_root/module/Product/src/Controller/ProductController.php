<?php

namespace Product\Controller;

use Product\Model\ProductTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * 商品コントローラークラス。
 */
class ProductController extends AbstractActionController
{
    /** @var \Product\Model\ProductTable $table */
    private ProductTable $table;

    /**
     * コンストラクタ。
     * ProductController は ProductTable に依存する。
     *
     * @param \Product\Model\ProductTable $table productsテーブル
     */
    public function __construct(ProductTable $table)
    {
        $this->table = $table;
    }

    /**
     * 商品一覧を表示する。
     * 商品一覧を表示するために、モデルから商品を取得し、ビューに渡す。
     *
     * @return Zend\View\Model\ViewModel 商品一覧
     */
    public function indexAction()
    {
        // ビューに変数を設定するために、 ViewModel のインスタンスを返す。
        return new ViewModel([
            // コンストラクタの最初のパラメータは、表現したいデータを含む配列。自動的にビュースクリプトに渡される。
            'products' => $this->table->fetchAll(),
        ]);
    }
}
