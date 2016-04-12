<?php
namespace DevGuru\SmsTrafficApi\Transport;

interface TransportInterface
{
    /**
     * Makes post http request
     * @param string $url
     * @param array  $postData
     * @return string
     */
    public function doRequest($url, array $postData);
}
