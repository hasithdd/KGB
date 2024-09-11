CREATE TABLE IF NOT EXISTS `categories` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(60) NOT NULL,
    category_id int(11) UNSIGNED,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`),
    CONSTRAINT `FK_products` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8;

INSERT INTO
    `categories` (`id`, `name`)
VALUES (1, 'fighter_jets'),
    (2, 'nuclear_bombs'),
    (3, 'balastic_missiles'),
    (4, 'battle_tanks'),
    (5, 'submarines'),
    (6, 'aircraft_carriers'),
    (7, 'helicopters'),
    (8, 'air_defence_systems');

CREATE TABLE IF NOT EXISTS `products` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `quantity` varchar(50) DEFAULT NULL,
    `buy_price` decimal(25, 2) DEFAULT NULL,
    `sale_price` decimal(25, 2) NOT NULL,
    `category_id` int(11) unsigned NOT NULL,
    `date` datetime NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`),
    KEY `category_id` (`category_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = utf8;

INSERT INTO
    `products` (
        `id`,
        `name`,
        `quantity`,
        `buy_price`,
        `sale_price`,
        `category_id`,
        `date`
    )
VALUES (
        1,
        'SU-35',
        '75',
        '100.00',
        '500.00',
        1,
        '2024-09-04 16:45:51'
    ),
    (
        2,
        'MIG-31',
        '150',
        '90.00',
        '450.00',
        1,
        '2024-09-04 18:44:52'
    ),
    (
        3,
        'TSAR-1',
        '15',
        '1500.00',
        '3500.00',
        2,
        '2024-09-04 18:48:53'
    ),
    (
        4,
        'TSAR-2',
        '6',
        '5000.00',
        '10000.00',
        2,
        '2024-09-04 19:03:23'
    ),
    (
        5,
        'Hypersonic',
        '750',
        '1.00',
        '1.50',
        3,
        '2024-09-04 19:11:30'
    ),
    (
        6,
        'Cruise',
        '1400',
        '1.50',
        '3.00',
        3,
        '2024-09-04 19:13:35'
    ),
    (
        7,
        'T-90',
        '1200',
        '30.00',
        '70.00',
        4,
        '2024-09-04 19:15:38'
    ),
    (
        8,
        'T-50',
        '650',
        '18.00',
        '36.00',
        4,
        '2024-09-04 19:17:11'
    ),
    (
        9,
        'TypHoon',
        '12',
        '1400.00',
        '4000.00',
        5,
        '2024-09-04 19:19:20'
    ),
    (
        10,
        'Nerpa',
        '3',
        '1500.00',
        '4500.00',
        5,
        '2024-09-04 19:20:28'
    ),
    (
        11,
        'Krylov',
        '2',
        '1020.00',
        '2050.00',
        6,
        '2024-09-04 19:25:22'
    ),
    (
        12,
        'Shtorm',
        '3',
        '1000',
        '1900.00',
        6,
        '2024-09-04 19:48:01'
    ),
    (
        13,
        'MI-26',
        '480',
        '2.00',
        '5.00',
        7,
        '2024-09-04 19:49:00'
    ),
    (
        14,
        'MI-24',
        '660',
        '1.00',
        '4.00',
        7,
        '2024-09-04 19:50:00'
    ),
    (
        15,
        'S-400',
        '960',
        '1.00',
        '1.50',
        8,
        '2024-09-04 19:50:00'
    ),
    (
        16,
        'S-200',
        '850',
        '1.00',
        '1.30',
        8,
        '2024-09-04 19:50:00'
    );

CREATE TABLE IF NOT EXISTS `sales` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `product_id` int(11) unsigned NOT NULL,
    `qty` int(11) NOT NULL,
    `price` decimal(25, 2) NOT NULL,
    `date` date NOT NULL,
    PRIMARY KEY (`id`),
    KEY `product_id` (`product_id`),
    CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8;

INSERT INTO
    `sales` (
        `id`,
        `product_id`,
        `qty`,
        `price`,
        `date`
    )
VALUES (
        1,
        1,
        5,
        '500.00',
        '2024-09-04'
    ),
    (
        2,
        2,
        10,
        '450.00',
        '2024-09-04'
    ),
    (
        3,
        3,
        2,
        '3500.00',
        '2024-09-04'
    ),
    (
        4,
        4,
        1,
        '10000.00',
        '2024-09-04'
    ),
    (
        5,
        5,
        100,
        '1.50',
        '2024-09-04'
    ),
    (
        6,
        6,
        200,
        '3.00',
        '2024-09-04'
    ),
    (
        7,
        7,
        50,
        '70.00',
        '2024-09-04'
    ),
    (
        8,
        8,
        25,
        '36.00',
        '2024-09-04'
    );

CREATE TABLE IF NOT EXISTS `user_groups` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `group_name` varchar(150) NOT NULL,
    `group_level` int(11) NOT NULL,
    `group_status` int(1) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `group_level` (`group_level`)
) ENGINE = InnoDB AUTO_INCREMENT = 4 DEFAULT CHARSET = latin1;

-- users
CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `user_level` int(11) NOT NULL DEFAULT 3,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    KEY `user_level` (`user_level`),
    CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO
    `user_groups` (
        `id`,
        `group_name`,
        `group_level`,
        `group_status`
    )
VALUES (1, 'Admin', 1, 1),
    (2, 'special', 2, 1),
    (3, 'User', 3, 1);

INSERT INTO
    `users` (
        `username`,
        `password`,
        `name`,
        `user_level`
    )
VALUES (
        'admin',
        '$2y$10$Q7.HH.h3Aed1RBaAJN1KBu/YGdCx8gNh4pb4uC/oDbwvpVEP8zOFu',
        'Admin',
        1
    );