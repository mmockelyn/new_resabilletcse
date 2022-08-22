<?php

namespace App\Services\Tradedoubler;

use Illuminate\Http\Client\HttpClientException;

class API
{
    private string|false $bearer_code;
    private $access_token;
    private string $endpoint;
    protected int $sources_id;

    public function __construct()
    {
        $this->bearer_code = base64_encode(config('ce.tradedoubler_client_id').':'.config('ce.tradedoubler_client_secret'));
        $this->endpoint = 'https://connect.tradedoubler.com/';
        $this->auth();
    }

    private function auth()
    {
        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://connect.tradedoubler.com/uaa/oauth/token");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);

            curl_setopt($ch, CURLOPT_POST, TRUE);

            $fields = <<<EOT
            grant_type=password&username=resabiletcse.com&password=CRIDIP85100

            EOT;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/x-www-form-urlencoded",
                "Authorization: Basic ".$this->bearer_code
            ));

            $response = curl_exec($ch);
            curl_close($ch);
            $d = json_decode(stristr($response, '{"access_token"'));
            $this->access_token = $d->access_token;
            $this->sources_id = $this->call('publisher/sources')[0]->id;
        }catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function call($uri,$method = 'GET', $data = []) {
        if (!isset($this->access_token)) {
            $this->auth();
        }
        switch ($method) {
            case 'GET':
                return \Http::withToken($this->access_token)->get($this->endpoint.$uri, $data)->object();
            case 'POST':
                return \Http::withToken($this->access_token)->post($this->endpoint.$uri, $data)->object();

            case 'PUT':
                return \Http::withToken($this->access_token)->put($this->endpoint.$uri, $data)->object();

            case 'DELETE':
                return \Http::withToken($this->access_token)->delete($this->endpoint.$uri, $data)->object();
        }
    }
}
