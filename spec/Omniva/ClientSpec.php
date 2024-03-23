<?php

declare(strict_types=1);

namespace spec\Omniva;

use Omniva\Client;
use PhpSpec\ObjectBehavior;
use GuzzleHttp\Client as HttpClient;

class ClientSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('username', 'password');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Client::class);
    }

    public function it_should_return_http_client(): void
    {
        $this->getHttpClient()->shouldHaveType(HttpClient::class);
    }
}
