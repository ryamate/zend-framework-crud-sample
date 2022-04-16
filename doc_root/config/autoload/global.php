<?php

/**
 * Global Configuration Override (グローバルコンフィギュレーションのオーバーライド)
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 * (このファイルは、モジュールなどから設定値をオーバーライドするために使用します。
 * このファイルには、環境に依存しない値や、セキュリティに敏感でない値を入れることになるでしょう。)
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 * (注意: 実際には、このファイルは通常ソースコードに含まれることになります。
 * そのため、パスワードやその他の機密情報をこのファイルに含めないでください。)
 */

return [
    // PDO を使って MySQL データベースに接続
    'db' => [
        'driver' => 'Pdo_Mysql',
        'dsn' => 'mysql:dbname=zf_sample;host=db;charset=utf8',
        'username' => 'db_user',
        'password' => 'secret',
    ],
    'translator' => [
        'locale' => 'en_US', // デフォルトのロケール（提供されていない場合
        'translation_file_patterns' => [ // 翻訳ファイルのパターン
            [
                'type' => 'phpArray', // 翻訳ソースの種類 (例: gettext、phpArray、ini)
                'base_dir' => getcwd() . '/data/language/ja', // それらが格納されているベースディレクトリ
                'pattern' => 'Zend_Validate.php', // 使用するファイルを特定するためのファイルパターン
            ],
        ],
    ],
];
