<?php
namespace DevGuru\SmsTrafficApi\Tests;

use DevGuru\SmsTrafficApi\Client;
use DevGuru\SmsTrafficApi\Sms\Sms;
use DevGuru\SmsTrafficApi\Transport\TransportInterface;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $transportMock = $this->getMock(TransportInterface::class);
        $transportMock->method('doRequest')->willReturn('<?xml version="1.0" ?><reply><result>OK</result><code>0</code><description>queued 2 messages</description> <message_infos><message_info> <phone>71112223456</phone> <sms_id>1000472891</sms_id></message_info></message_infos></reply>');

        $client = new Client('login', 'password', 'originator');
        $client->setTransport($transportMock);
        $result = $client->send(new Sms('Phone', 'Message'));
        $this->assertEquals(71112223456, $result['message_infos']['message_info']['phone']);
    }

    /**
     * @expectedException \DevGuru\SmsTrafficApi\Exception\ParsingException
     */
    public function testParsingException()
    {
        $transportMock = $this->getMock(TransportInterface::class);
        $transportMock->method('doRequest')->willReturn('<?xml version="1.0" ?><reply><result>OK</result><code1>0</code1><description>queued 1 messages</description></reply>');

        $client = new Client('login', 'password', 'originator');
        $client->setTransport($transportMock);
        $client->send(new Sms('Phone', 'Message'));
    }

    /**
     * @expectedException \DevGuru\SmsTrafficApi\Exception\SendingException
     * @expectedExceptionCode 401
     * @expectedExceptionMessage login param is missing
     */
    public function testSendingException()
    {
        $transportMock = $this->getMock(TransportInterface::class);
        $transportMock->method('doRequest')->willReturn('<?xml version="1.0" ?><reply><result>ERROR</result><code>401</code><description>login param is missing</description></reply>');

        $client = new Client('login', 'password', 'originator');
        $client->setTransport($transportMock);
        $client->send(new Sms('Phone', 'Message'));
    }
}