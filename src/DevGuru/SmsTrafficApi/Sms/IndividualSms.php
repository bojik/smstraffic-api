<?php
namespace DevGuru\SmsTrafficApi\Sms;

class IndividualSms extends AbstractSms
{
    protected $phoneMessages = [];

    /**
     * IndividualSms constructor.
     * @param array $phoneMessages Example [['780012312312', 'First Message'], ['780012312313', 'Second Message']]
     */
    public function __construct(array $phoneMessages = [])
    {
        parent::__construct([self::PARAMETER_INDIVIDUAL_MESSAGES => '1']);
        $this->phoneMessages = $phoneMessages;
    }

    /**
     * Put sms to the message list
     * @param string $phone
     * @param string $message
     * @return $this
     */
    public function addMessage($phone, $message)
    {
        $this->phoneMessages[] = [$phone, $message];

        return $this;
    }

    /**
     * Returns sms sending parameters
     * @return array
     */
    public function getParameters()
    {
        $ret = parent::getParameters();
        $ret[self::PARAMETER_PHONES] = $this->generatePhoneParameter();
        return $ret;
    }

    /**
     * @return string
     */
    protected function generatePhoneParameter()
    {
        $ret = [];
        foreach ($this->phoneMessages as $param) {
            $ret[] = implode(' ', $param);
        }
        return implode("\n", $ret);
    }
}
