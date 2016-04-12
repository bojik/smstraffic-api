<?php
namespace DevGuru\SmsTrafficApi\Transport;

use GuzzleHttp\Client as HttpClient;

class GuzzleHttpTransport implements TransportInterface
{
    const REQUEST_TIMEOUT = 120;

    /**
     * Makes post http request
     * @param string $url
     * @param array  $postData
     * @return string
     */
    public function doRequest($url, array $postData)
    {
        $client = new HttpClient();
        $response = $client->post($url, ['form_params' => $postData, 'timeout' => self::REQUEST_TIMEOUT]);

        return $response->getBody()->__toString();
    }
}
