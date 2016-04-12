<?php
namespace DevGuru\SmsTrafficApi;

use DevGuru\SmsTrafficApi\Exception\ParsingException;
use DevGuru\SmsTrafficApi\Exception\SendingException;
use DevGuru\SmsTrafficApi\Exception\TransportException;
use DevGuru\SmsTrafficApi\Sms\AbstractSms;
use DevGuru\SmsTrafficApi\Transport\GuzzleHttpTransport;
use DevGuru\SmsTrafficApi\Transport\TransportInterface;
use Exception;

class Client
{
    /**
     * API version
     */
    const VERSION = '1.84';

    /**
     * API Url by default
     */
    const DEFAULT_API_URL = 'https://www.smstraffic.ru/multi.php';

    /**
     * Sms Traffic Login
     * @var string
     */
    protected $login;

    /**
     * Sms Traffic Password
     * @var string
     */
    protected $password;

    /**
     * Message sender
     * @var string
     */
    protected $originator;

    /**
     * Sms Traffic URL
     * @var string
     */
    protected $apiUrl = self::DEFAULT_API_URL;

    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * Client constructor.
     * @param string      $login Sms Traffic login
     * @param string      $password Sms Traffic Password
     * @param string|null $originator Sms sender
     */
    public function __construct($login, $password, $originator = null)
    {
        $this->login = $login;
        $this->password = $password;
        $this->originator = $originator;
    }

    /**
     * Sends message
     * @param AbstractSms $sms
     * @return array
     * @throws ParsingException
     * @throws SendingException
     * @throws TransportException
     */
    public function send(AbstractSms $sms)
    {
        if (!$this->transport instanceof TransportInterface) {
            $this->transport = new GuzzleHttpTransport();
        }

        $params = $sms->getParameters();
        $params[$sms::PARAMETER_LOGIN] = $this->login;
        $params[$sms::PARAMETER_PASSWORD] = $this->password;
        $params[$sms::PARAMETER_ORIGINATOR] = $this->originator;

        try {
            $result = $this->transport->doRequest($this->apiUrl, $params);
        } catch (Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->parseSendingResult($result);
    }

    /**
     * @param TransportInterface $transport
     * @return $this
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * @param string $apiUrl
     * @return $this
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    /**
     * Parses sending result
     * @param string $result
     * @return array
     * @throws ParsingException
     * @throws SendingException
     */
    protected function parseSendingResult($result)
    {
        $xml = simplexml_load_string($result);
        $ret = json_decode(json_encode($xml), true);
        $requiredFields = ['result', 'code'];
        foreach ($requiredFields as $field) {
            if (!isset($ret[$field])) {
                throw new ParsingException("Incorrect answer. Key '".$field."' does not exist.");
            }
        }
        if ($ret['code'] != 0) {
            $message = empty($ret['description']) ? 'Unknown Error' : $ret['description'];
            throw (new SendingException($message, intval($ret['code'])))->setAnswer($result);
        }

        return $ret;
    }
}
