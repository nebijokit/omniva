<?php

namespace spec\Omniva;

use Omniva\Client;
use PhpSpec\ObjectBehavior;
use GuzzleHttp\Client as HttpClient;

class ClientSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('username', 'password');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }

    public function it_should_return_http_client()
    {
        $this->getHttpClient()->shouldHaveType(HttpClient::class);
    }
}
