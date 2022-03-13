# zend-framework-crud-sample

## DB

### Sequel Ace をインストールする（使用する場合）

- Sequel Ace は、データベースに接続するツール。

- ターミナルで下記コマンドを実行する。

```bash
brew install --cask sequel-ace
```

### Sequel Ace を起動して下記を入力して接続をクリックする。

- Host: 127.0.0.1
- User: db_user
- Password: secret
- Database: zf_sample

## データベースの再作成

### ユースケース

- サンプルデータが変更された場合
- ゴミデータが増えてしまった場合
- データベースの設定を変更してしまって元に戻せなくなった場合

### 手順

1. 仮想化環境を終了する。
2. 下記コマンドを実行して仮想化環境とデータベースのデータを保存しているボリュームを削除する。

```bash
docker-compose down --volumes
```

3. 下記コマンドを実行して仮想化環境を再作成する。

```bash
docker-compose up -d
```

#### 注意事項

- 後から追加したデータは消える。
