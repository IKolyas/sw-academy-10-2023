CREATE TABLE IF NOT EXISTS `users`
(
    `id`            BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `first_name`    VARCHAR(255) NOT NULL,
    `last_name`     VARCHAR(255) NOT NULL,
    `login`         VARCHAR(255) NOT NULL UNIQUE,
    `password`      VARCHAR(255) NOT NULL,
    `email`         VARCHAR(255) UNIQUE NOT NULL,
    `is_admin`      BOOLEAN DEFAULT FALSE
);