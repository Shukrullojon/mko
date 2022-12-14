<?php

return [
    'search' => "Поиск",
    'payment' => [
        'payment' => "Оплата",
    ],
    'client' => [
        'clients' => "Клиенты",
    ],
    'account' => [
        'account' => 'Счета',
        'type' => 'Тип',
        'account_number' => 'Счет',
        'inn' => 'Инн',
        'name' => 'Название',
        'filial' => 'Филиал',
        'percentage' => 'Процент',
        'card' => 'Кошелек',
        'account_inn' => 'Инн',
        'account_filial' => 'Филиал аккаунта',
    ],
    'brand' => [
        'brands' => 'Бренды',
        'brand_name' => 'Бренд',
        'logo' => 'Логотип',
        'status' => 'Статус',
        'is_unired' => 'Униред',
    ],
    'status' => [
        '1' => '✅',
        '0' => '❌',
    ],
    'ucoin' => "UCOIN",
    'expire' => "Срок",
    "balance" => "Баланс",
    'merchant' => [
        'merchant' => 'Мерчант',
        'terminal' => 'Терминал',
        'merchants' => 'Мерчанты',
        'merchant_month' => 'Месяц Мерчантa',
        'merchant_period' => 'Период',
        'merchant_percentage' => 'Процент',
        'brand_id' => 'Ид Бренда',
        'merchant_name' => 'Имя',
        'account_id' => 'Ид Аккаунта',
        'key' => 'Ключ',
        'card' => 'Кошелек',
        'is_register_uzcard' => 'регистрация uzcard',
        'is_register_humo' => 'регистрация humo',
        'filial' => 'Филиал',
        'merchant_address' => 'Адрес',
        'address' => 'Адрес',
        'uzcard_merchant_id' => 'Ид Мерчанта uzcard',
        'humo_merchant_id' => 'Ид Мерчанта humo',
        'uzcard_terminal_id' => 'Ид Терминала uzcard',
        'humo_terminal_id' => 'Ид Терминала humo',
    ],
    'userManagement' => [
        'title'          => 'Управление пользователями',
        'title_singular' => 'Управление',
    ],
    'permission'     => [
        'title'          => 'Управление разрешениями',
        'title_singular' => 'Разрешение',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Комментарий',
            'name'              => 'Название',
            'roles'             => 'Роли',
            'permissions'       => 'Разрешения',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role'           => [
        'title'          => 'Управление ролями',
        'title_singular' => 'Роль',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'roles'             => 'Роли',
            'title'             => 'Комментарий',
            'name'              => 'Название',
            'title_helper'       => ' ',
            'permissions'        => 'Разрешение рола',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user'           => [
        'title'          => 'Пользователи',
        'title_singular' => 'Пользователь',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Имя',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Пароль',
            'password_helper'          => ' ',
            'roles'                    => 'Роли',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
        ],
    ],
];
