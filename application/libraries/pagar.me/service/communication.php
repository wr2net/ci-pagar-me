<?php

require_once __DIR__ . "/../service/logtransactions.php";
require_once __DIR__ . "/../parser/parser.php";

class Communication
{
    /**
     * @var string
     */
    const BASE_URI = 'https://api.pagar.me/1/%s';

    /**
     * @var string header used to identify application's requests
     */
    const USER_AGENT_HEADER = 'X-PagarMe-User-Agent';

    /**
     * @var string header used to identify application's requests
     */
    const CONTENT_TYPE_HEADER = 'Content-Type: application/json';

    /**
     * @var string for status 200 returned
     */
    const STATUS_200 = 'Tudo ocorreu como deveria e sua requisição foi processada com sucesso.';

    /**
     * @var string for status 400 returned
     */
    const STATUS_400 = 'Algum parâmetro obrigatório não foi passado, ou os parâmetros passados não estão corretos.';

    /**
     * @var string for status 401 returned
     */
    const STATUS_401 = 'Falta de autorização para acessar este endpoint.';

    /**
     * @var string for status 404 returned
     */
    const STATUS_404 = 'Endpoint não encontrado, revise a URL passada.';

    /**
     * @var string for status 500 returned
     */
    const STATUS_500 = 'Erro interno do Pagar.me, tente sua requisição novamente. Caso o erro continue, entre em contato com o suporte técnico.';

    /**
     * @var LogTransactions
     */
    private $log_message;

    private $parser;

    /**
     * @var string
     */
    private $location = __DIR__ . "/../../log/";

    public function __construct()
    {
        $this->log_message = new LogTransactions();
        $this->parser = new Parser();
    }

    /**
     * @param $data
     * @param $transactionType
     * @return false|string
     */
    public function communication($data, $transactionType)
    {
        $uri = sprintf(self::BASE_URI, $transactionType);

        /*
         * Data Parser for transactions
         */
        $parsedData = $this->parser->dataParse($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parsedData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                self::CONTENT_TYPE_HEADER,
                self::USER_AGENT_HEADER
            ]
        );
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return $this->hendlerReturn($info, $response);
    }

    /**
     * @param array $info
     * @param $response
     * @return false|string
     */
    private function hendlerReturn(array $info, $response)
    {
        if ($info['http_code'] == 200) {
            $output = json_decode($response);
            $output->error = false;
            $output->message = self::STATUS_200;
            $response = $output;

            /**
             * LOG
             */
            $this->log_message->log_message(self::STATUS_200, 2, $this->location);
        }

        if ($info['http_code'] == 400) {
            $response = [
                "error" => true,
                "code" => $info['http_code'],
                "message" => self::STATUS_400
            ];

            /**
             * LOG
             */
            $this->log_message->log_message(self::STATUS_400, 1, $this->location);
        }

        if ($info['http_code'] == 401) {
            $response = [
                "error" => true,
                "code" => $info['http_code'],
                "message" => self::STATUS_401
            ];

            /**
             * LOG
             */
            $this->log_message->log_message(self::STATUS_401, 1, $this->location);
        }

        if ($info['http_code'] == 404) {
            $response = [
                "error" => true,
                "code" => $info['http_code'],
                "message" => self::STATUS_404
            ];

            /**
             * LOG
             */
            $this->log_message->log_message(self::STATUS_404, 1, $this->location);
        }

        if ($info['http_code'] == 500) {
            $response = [
                "error" => true,
                "code" => $info['http_code'],
                "message" => self::STATUS_500
            ];

            /**
             * LOG
             */
            $this->log_message->log_message(self::STATUS_500, 1, $this->location);
        }

        return json_encode($response);
    }
}