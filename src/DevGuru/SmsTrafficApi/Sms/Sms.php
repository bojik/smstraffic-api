<?php
namespace DevGuru\SmsTrafficApi\Sms;

class Sms extends AbstractSms
{
    /**
     * Sms constructor.
     * @param array|int|string $phones
     * @param string           $message
     */
    public function __construct($phones, $message)
    {
        parent::__construct([self::PARAMETER_PHONES => $phones, self::PARAMETER_MESSAGE => $message]);
    }
}
