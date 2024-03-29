<?php
/**
 * Cabeçalhos de tabelas e descrição de campos de formulário ficam neste arquivo.
 * Descrições com nome genérico devem começar com underline.
 */

return [
    'auth' => [
        'email' => 'Email',
        'password' => 'Senha',
        'password_confirmation' => 'Confirmar senha',
        'new_password' => 'Nova senha',
    ],

    'common' => [
        'name' => 'Nome',
        'observation' => 'Observação',
        'created_at' => 'Criado em',
        'updated_at' => 'Atualizado em',
        'actions' => 'Ações',
        'title' => 'Título',
        'description' => 'Descrição',
    ],

    'products' => [
        'description' => 'Descrição',
        'category' => 'Categoria',
        'ncm' => 'NCM',
        'code' => 'Código',
        'price_nfe' => 'Preço nota fiscal eletrônica',
        'price_nfc' => 'Preço nota fiscal do consumidor',
        'commercial_unit' => 'Unidade comercial',
        'taxable_unit' => 'Unidade tributável',
        'cfop_nfc' => 'CFOP nota fiscal do consumidor',
        'cfop_nfe' => 'CFOP nota fiscal eletrônica',
        'taxable_quantity' => 'Quantidade tributável',
        'minimal_quantity' => 'Quantidade mínima',
    ],

    'companies' => [
        'name' => 'Nome Fantasia' ,
        'corporate_name' => 'Razão Social',
    ],

    'categories' => [
        'name' => 'Nome da categoria',
        'category' => 'Categoria pai',
    ],

    'orders' => [
        'client' => 'Cliente',
        'payment_form' => 'Forma de pagamento',
        'status' => 'Status'
    ]
];
