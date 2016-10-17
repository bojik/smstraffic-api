<?php
namespace DevGuru\SmsTrafficApi\Tests\Sms;

use DevGuru\SmsTrafficApi\Sms\IndividualSms;

/**
 * Class IndividualSmsTest
 * @package DevGuru\SmsTrafficApi\Tests\Sms
 */
class IndividualSmsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testGetParameters
     */
    public function testGetParameters()
    {
        $sms = new IndividualSms([['78001231231', 'First Message']]);
        $sms->addMessage('78001231230', 'Second Message');
        $parameters = $sms->getParameters();
        $this->assertEquals(1, $parameters[$sms::PARAMETER_INDIVIDUAL_MESSAGES]);
        $this->assertEquals("78001231231 First Message\n78001231230 Second Message", $parameters[$sms::PARAMETER_PHONES]);
    }
}
