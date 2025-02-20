<?php

namespace Tests\Unit;

use Tests\TestCase;
use Zerotoprod\SpapiOrders\SpapiOrders;
use Zerotoprod\SpapiOrders\Support\Testing\SpapiOrdersFake;
use Zerotoprod\SpapiOrders\Support\Testing\SpapiOrdersResponseFactory;

class ExampleTest extends TestCase
{
    /** @test */
    public function fakes_response(): void
    {
        $response = SpapiOrdersFake::fake(['response' => ['payload' => ['order' => 1]]]);

        SpapiOrders::from('access_token')->getOrder('123-1234567-1234567');

        $this->assertEquals(1, $response->getOrder('123-1234567-1234567')['response']['payload']['order']);
    }

    /** @test */
    public function using_factory(): void
    {
        $response = SpapiOrdersFake::fake(
            SpapiOrdersResponseFactory::factory([
                'response' => ['payload' => ['order' => 1]]
            ])->make()
        );

        SpapiOrders::from('access_token')->getOrder('123-1234567-1234567');

        $this->assertEquals(1, $response->getOrder('123-1234567-1234567')['response']['payload']['order']);
    }
}