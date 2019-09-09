<?php
return [

    /**
     * Cabeçalhos, ítens do menu e breadcrumbs devem ficar neste arquivo.
     * Cabeçalhos com nome genérico devem começar com underline.
     */

    'auth' => [
        'sign_in' => 'Login',
        'reset_password' => 'Recuperar senha',
        'create_new_password' => 'Criar nova senha',
    ],

    'users' => [
        'common' => [
            'index' => 'Usuários',
            'show' => 'Detalhes do Usuário',
            'edit' => 'Editar Usuário',
            'create' => 'Cadastrar Usuário'
        ],

        'admins' => [
            'index' => 'Administradores',
            'show' => 'Detalhes do Administrador',
            'edit' => 'Editar Administrador',
            'create' => 'Cadastrar Administrador'
        ],

        'clients' => [
            'index' => 'Clientes',
            'show' => 'Detalhes do Cliente',
            'edit' => 'Editar Cliente',
            'create' => 'Cadastrar Cliente'
        ],
    ],
];
