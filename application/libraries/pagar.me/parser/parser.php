<?php

class Parser
{
    /**
     * @param $data
     * @return array
     */
    public function dataParse($data)
    {
        return [
            'amount' => $data['valor'],
            'payment_method' => $data['metodo'],
            'async' => false,
            'customer' => [
                'external_id' => $data['cliente']['id'],
                'name' => $data['cliente']['nome'],
                'type' => $data['cliente']['tipo'],
                'country' => $data['cliente']['regiao'],
                'documents' => [
                    [
                        'type' => $data['cliente']['documentos']['tipo'],
                        'number' => $data['cliente']['documentos']['numero'],
                    ]
                ],
                'phone_numbers' => [$data['cliente']['telefone']],
                'email' => $data['cliente']['email'],
            ]
        ];
    }
}