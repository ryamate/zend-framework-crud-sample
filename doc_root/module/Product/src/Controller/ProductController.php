<?php

namespace Product\Controller;

use Product\Form\ProductForm;
use Product\Model\Product;
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

    /**
     * 商品を新規登録する。
     * フォームからデータを取得し、新しい商品の行を保存し、商品一覧にリダイレクトする。
     *
     * @return Response|array
     */
    public function addAction()
    {
        // ProductFormインスタンスを作成し、送信ボタンのラベルを "新規登録" に設定する。
        $form = new ProductForm();
        $form->get('submit')->setValue('新規登録');

        $request = $this->getRequest();

        // POSTでない場合、フォームデータは送信されていないのでフォームを表示する(zend-mvcでは、ビューモデルの代わりにデータの配列を返せる)。
        if (!$request->isPost()) {
            return ['form' => $form];
        }

        // フォームの投稿があるため、Productインスタンスを作成し、入力フィルタをフォームに渡し、リクエストインスタンスからフォームに送信されたデータを渡す。
        $product = new Product();
        $form->setInputFilter($product->getInputFilter());
        $form->setData($request->getPost());
        // バリデーション失敗の場合、フォームを再表示する(バリデーション失敗の内容を、ビューレイヤーに伝える)。
        if (!$form->isValid()) {
            return ['form' => $form];
        }

        // フォームからデータを取得し、新しい商品の行を保存し、Redirectコントローラプラグインを使って商品一覧にリダイレクトする。
        $product->exchangeArray($form->getData());
        $this->table->createProduct($product);
        return $this->redirect()->toRoute('product');
    }
}
