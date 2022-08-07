<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.name' => 'Название',
    'column.guard_name' => 'Guard Name',
    'column.roles' => 'Роли',
    'column.permissions' => 'Права',
    'column.updated_at' => 'Обновлено',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field.name' => 'Name',
    'field.guard_name' => 'Guard Name',
    'field.permissions' => 'Permissions',
    'field.select_all.name' => 'Выделить все',
    'field.select_all.message' => 'Enable all Permissions currently <span class="text-primary font-medium">Enabled</span> for this role',

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav.group' => 'Настройка прав',
    'nav.role.label' => 'Права',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'Роль',
    'resource.label.roles' => 'Роли',

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */

    'section' => 'Объекты',
    'resources' => 'Ресурсы',
    'widgets' => 'Виджеты',
    'pages' => 'Страницы',
    'custom' => 'Свои настройки доступов',

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'forbidden' => 'Недостаточно прав',

    /*
    |--------------------------------------------------------------------------
    | Resource Permissions' Labels
    |--------------------------------------------------------------------------
    */

    'resource_permission_prefixes_labels' => [
        'view' => 'Просмотр',
        'view_any' => 'Просмотр всех',
        'create' => 'Создание',
        'update' => 'Обновление',
        'delete' => 'Удаление',
        'delete_any' => 'Удаление всех',
        'force_delete' => 'Force Delete',
        'force_delete_any' => 'Force Delete Any',
        'restore' => 'Restore',
        'reorder' => 'Reorder',
        'restore_any' => 'Restore Any',
        'replicate' => 'Replicate',
    ],
];
