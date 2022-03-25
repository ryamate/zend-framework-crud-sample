# zend-framework-crud-sample

[ブログ記事：諸事情で Zend Framework を理解する 2022](https://ryamate.hatenablog.com/entry/2022/03/12/諸事情で_Zend_Framework_を理解する_2022_-_①Docker_での開発環境構築)

## クローンして、ブラウザでアクセスするまでの手順

```bash
$ git clone https://github.com/ryamate/zend-framework-crud-sample.git

$ cd zend-framework-crud-sample

# Dockerコンテナを作成・起動する
$ docker-compose up -d --build

# composer.lockの内容をもとにパッケージのインストールを行う
$ docker-compose exec app composer install
```

下記 URL にブラウザでアクセスします

[http://localhost/](http://localhost/)

## 商品管理ページの構成

| ページ   | 説明                                                                   |
| -------- | ---------------------------------------------------------------------- |
| 商品一覧 | 商品の一覧を表示。商品の新規登録や編集、削除のためのリンクボタン表示。 |
| 商品登録 | 新規商品を登録するためのフォーム。                                     |
| 商品編集 | 商品を編集するためのフォーム。                                         |
| 商品削除 | 商品を削除することを確認し、削除するページ。                           |

## products テーブル設計

| フィールド名 | 名前         | データ型     | オプションなど                                                  |
| ------------ | ------------ | ------------ | --------------------------------------------------------------- |
| id           | ID           | INTEGER      | PRIMARY KEY, AUTO INCREMENT                                     |
| item_name    | 商品名       | VARCHAR(256) | NOT NULL                                                        |
| price        | 商品単価     | INTEGER      | NOT NULL                                                        |
| image        | 商品画像パス | VARCHAR(256) |                                                                 |
| delete_flag  | 論理削除     | BOOLEAN      | DEFAULT FALSE, NOT NULL                                         |
| created_at   | 作成日       | DATETIME     | DEFAULT CURRENT_TIMESTAMP, NOT NULL                             |
| updated_at   | 更新日       | DATETIME     | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, NOT NULL |

## ディレクトリ構成

Zend Framework のパッケージ `zend-mvc` はモジュールシステムを使用して、各モジュールごとにコードを整理します。

```
doc_root/
    module/
        Application/
        Product/
            config/
            src/
                Controller/
                Form/
                Model/
            view/
                product/
                    product/
```

Module ディレクトリ以下に、 Product ディレクトリを Application ディレクトリと同一の階層で作成し、 Product に関する MVC 構成をその中で構築します。(Zend Framework は Module 単位で MVC 構成を構築します）

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
