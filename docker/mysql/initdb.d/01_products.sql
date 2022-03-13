SET CHARACTER_SET_CLIENT = utf8;
SET CHARACTER_SET_CONNECTION = utf8;

CREATE TABLE products (
    id                    INTEGER AUTO_INCREMENT PRIMARY KEY,
    item_name             VARCHAR(256) NOT NULL,
    price                 INTEGER NOT NULL,
    image                 VARCHAR(256),
    delete_flag           BOOLEAN NOT NULL DEFAULT FALSE,
    created_at            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO
    products (item_name, price, image)
VALUES
    ('日替わりランチA', 600, null),
    ('日替わりランチB', 800, null),
    ('日替わりランチC', 1000, null);
