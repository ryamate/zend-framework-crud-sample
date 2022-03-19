<?php

namespace Product\Model;

use RuntimeException;
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
}
