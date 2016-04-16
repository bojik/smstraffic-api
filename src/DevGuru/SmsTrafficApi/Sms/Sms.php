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
        if (is_array($phones)) {
            $phones = implode(',', $phones);
        }
        parent::__construct([self::PARAMETER_PHONES => $phones, self::PARAMETER_MESSAGE => $message]);
    }
}
