<?php

namespace Product\Model;

use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * 商品のデータベース・テーブルに対する操作を実行するクラス。
 */
class ProductTable
{
    /** @var \Zend\Db\TableGateway\TableGatewayInterface $tableGateway */
    private TableGatewayInterface $tableGateway;

    /**
     * コンストラクタ。
     * 渡された TableGateway インスタンスを $tableGateway に設定する。
     * TableGateway インスタンスを使用して、データベースのテーブルから行を検索、挿入、更新、削除する。
     * （これにより、テスト時にモックインスタンスを含む別の実装を簡単に提供することができる）
     *
     * @param \Zend\Db\TableGateway\TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * データベースからすべての商品のカラムをResultSetとして取得する。
     *
     * @return Zend\Db\ResultSet\ResultSet データベースから取得したすべての商品のカラム
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * データベースに新しい行を作成する。
     *
     * @param Product $product 新しく作成する商品のカラム
     * @return void
     */
    public function createProduct(Product $product)
    {
        $data = [
            'item_name' => $product->itemName,
            'price' => $product->price,
            'image' => $product->image,
        ];

        $this->tableGateway->insert($data);
    }

    /**
     * 一行を Product オブジェクトとして取得する。
     *
     * @param string $id 商品ID
     * @return
     */
    public function getProduct(string $id)
    {
        return $this->tableGateway->select(['id' => $id])->current();
    }

    /**
     * データベースの既に存在する行を更新する。
     *
     * @param Product $product 既に存在する商品のカラム
     * @return void
     */
    public function editProduct(Product $product)
    {
        $data = [
            'item_name' => $product->itemName,
            'price' => $product->price,
            'image' => $product->image,
        ];

        $product = $this->getProduct($product->id);
        if (isset($product)) {
            $this->tableGateway->update($data, ['id' => $product->id]);
        }
    }

    /**
     * 渡された $id の行を完全に削除する。
     *
     * @param string $id 商品ID
     * @return void
     */
    public function deleteProduct(string $id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
