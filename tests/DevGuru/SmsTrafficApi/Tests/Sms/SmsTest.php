<?php
namespace DevGuru\SmsTrafficApi\Tests\Sms;

use DevGuru\SmsTrafficApi\Sms\Sms;

class SmsTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultParameter()
    {
        $sms = new Sms('Phones', 'Message');
        $this->assertEquals('Phones', $sms->getParameter($sms::PARAMETER_PHONES));
        $this->assertEquals('Message', $sms->getParameter($sms::PARAMETER_MESSAGE));
        $this->assertEquals($sms::ENCODING_UTF8, $sms->getParameter($sms::PARAMETER_ENCODING));
    }

    public function testUpdateParameters()
    {
        $sms = new Sms('Phones', 'Message');
        $sms->updateParameters([$sms::PARAMETER_PHONES => 'NewPhone']);
        $this->assertEquals('NewPhone', $sms->getParameter($sms::PARAMETER_PHONES));
    }

    public function testSetParameters()
    {
        $sms = new Sms('Phones', 'Message');
        $sms->setParameters([$sms::PARAMETER_PHONES => 'NewPhone']);
        $this->assertEquals([$sms::PARAMETER_PHONES => 'NewPhone'], $sms->getParameters());
    }

    public function testSetEncoding()
    {
        $sms = new Sms('Phones', 'Message');
        $date = new \DateTime('2016-01-01 22:23:23');
        $sms->setEncoding($sms::ENCODING_CP1251)
            ->setStartDate($date)
            ->setGap('0.05');
        $expected = [
            $sms::PARAMETER_ENCODING => $sms::ENCODING_CP1251,
            $sms::PARAMETER_PHONES => 'Phones',
            $sms::PARAMETER_MESSAGE => 'Message',
            $sms::PARAMETER_START_DATE => $date->format($sms::DATE_FORMAT),
            $sms::PARAMETER_GAP => '0.05'
        ];
        $this->assertEquals($expected, $sms->getParameters());
    }

}