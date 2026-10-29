<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'string' => 'O campo :attribute deve ser um texto.',
    'numeric' => 'O campo :attribute deve ser um número.',
    'integer' => 'O campo :attribute deve ser um número inteiro.',
    'min' => [
        'numeric' => 'O campo :attribute deve ser no mínimo :min.',
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
    ],
    'max' => [
        'numeric' => 'O campo :attribute não pode ser maior que :max.',
        'string' => 'O campo :attribute não pode ter mais que :max caracteres.',
    ],
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'unique' => 'Este :attribute já está cadastrado.',
    'exists' => 'O :attribute selecionado é inválido.',
    'in' => 'O valor selecionado para :attribute é inválido.',
    'date' => 'O campo :attribute deve ser uma data válida.',
    'attributes' => [
        'name' => 'nome', 'category' => 'categoria', 'price' => 'preço',
        'stock' => 'estoque', 'minimum_stock' => 'estoque mínimo',
        'client_id' => 'cliente', 'product_id' => 'produto', 'quantity' => 'quantidade',
        'email' => 'e-mail', 'order_id' => 'pedido', 'address' => 'endereço',
        'fee' => 'taxa', 'expected_date' => 'data prevista', 'status' => 'status',
    ],
];
