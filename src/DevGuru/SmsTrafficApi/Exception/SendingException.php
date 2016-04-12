<?php
namespace DevGuru\SmsTrafficApi\Exception;

class SendingException extends SmsTrafficApiException
{
    /**
     * @var string
     */
    protected $answer;

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     * @return $this
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }
}
