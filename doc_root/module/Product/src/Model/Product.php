<?php

namespace Product\Model;

/**
 * 商品モデルクラス。
 * zend-db の TableGateway クラスで動作させるために、 exchangeArray() メソッドを実装する。
 */
class Product
{
    public int $id;
    public string $itemName;
    public int $price;
    public ?string $image;

    /**
     * 指定した配列からデータをエンティティのプロパティにコピーする。
     * (zend-db の TableGateway クラスで動作させるため)
     *
     * @param array $data
     * @return void
     */
    public function exchangeArray(array $data)
    {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->itemName = isset($data['item_name']) ? $data['item_name'] : null;
        $this->price = isset($data['price']) ? $data['price'] : null;
        $this->image = isset($data['image']) ? $data['image'] : null;
    }
}
