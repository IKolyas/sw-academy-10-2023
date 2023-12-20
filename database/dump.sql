DROP TABLE IF EXISTS `records`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id`           BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `login`        VARCHAR(45)        NOT NULL UNIQUE,
    `password`     VARCHAR(255)       NOT NULL,
    `email`        VARCHAR(45)        NOT NULL UNIQUE,
    `first_name`   VARCHAR(45)        NULL,
    `last_name`    VARCHAR(45)        NULL,
    `access_token` VARCHAR(255)       NULL,
    `is_admin`     BOOL               NOT NULL DEFAULT FALSE,
    `status`       INTEGER            NOT NULL DEFAULT 1,
    `photo`        VARCHAR(255)       NOT NULL DEFAULT 'uploads/orig.jpeg',
    `created_at`   TIMESTAMP          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   TIMESTAMP          NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `records`
(
    `id`      BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT             NOT NULL,
    `status`  INTEGER            NOT NULL DEFAULT 1,
    `date`    DATE               NOT NULL,
    `type`    integer            NOT NULL DEFAULT 1,
    `note`    TEXT               NULL,
    KEY `fk_records_users_user_id` (`user_id`),
    CONSTRAINT `fk_records_users_user_id` FOREIGN KEY `fk_records_users_user_id` (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

INSERT INTO `users` (`login`, `password`, `email`, `first_name`, `last_name`, `access_token`, `is_admin`, `status`)
VALUES ('admin', 'admin', 'admin@localhost', 'admin', 'admin', null, true, 1),
       ('anton', 'password', 'anton@localhost', 'Антон', null, null, false, 1),
       ('nikita', 'password', 'nikita@localhost', 'Никита', null, null, false, 1),
       ('nastya', 'password', 'nastya@localhost', 'Настя', null, null, false, 1),
       ('aleksandr', 'password', 'aleksandr@localhost', 'Александр', null, null, false, 1);

INSERT INTO `records` (`user_id`, `status`, `date`, `type`, `note`)
VALUES (2, 1, DATE_ADD(NOW(), INTERVAL +1 DAY), 1, 'test note'),
       (3, 1, DATE_ADD(NOW(), INTERVAL +2 DAY), 1, 'test note'),
       (4, 1, DATE_ADD(NOW(), INTERVAL +3 DAY), 1, 'test note'),
       (5, 1, DATE_ADD(NOW(), INTERVAL +4 DAY), 1, 'test note');
