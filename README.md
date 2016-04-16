# SMS Traffic API

[SMS Traffic](http://www.smstraffic.ru/) is full-cycle SMS aggregator. This project is an implementation of API by HTTP Protocol.

Usage:

```php
    
    use DevGuru\SmsTrafficApi\Client;
    use DevGuru\SmsTrafficApi\Sms\Sms;

    $client = new Client('login', 'password', 'originator');
    $result = $client->send(new Sms('Phone', 'Message'));

```

## Documentation
