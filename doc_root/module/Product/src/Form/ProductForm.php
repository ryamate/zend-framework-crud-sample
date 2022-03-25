<?php

namespace Product\Form;

use Zend\Form\Form;

/**
 * 商品フォームクラス。
 * 商品の新規登録・編集に使用する。
 */
class ProductForm extends Form
{
    /**
     * コンストラクタ。
     *
     * 親のコンストラクタを呼び出す際にフォームの名前を設定する。コンストラクタに指定された名前は無視する。
     * フォーム要素を設定する。各項目について、表示されるラベルを含むさまざまな属性やオプションを設定する。
     * - name 属性は テーブルのフィールド名に合わせている。
     *
     * @param mixed $name 指定されているが、使用されない。
     */
    public function __construct($name = null)
    {
        parent::__construct('product');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'item_name',
            'type' => 'text',
            'options' => [
                'label' => '商品名',
            ],
        ]);
        $this->add([
            'name' => 'price',
            'type' => 'text',
            'options' => [
                'label' => '商品単価',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}
