<?php

namespace Omnipay\GingerPayments\Message;

use Omnipay\Common\Issuer;
use Omnipay\Tests\TestCase;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class FetchIssuersRequestTest extends TestCase
{
    /**
     * @var FetchIssuersRequest
     */
    protected $request;

    public function setUp()
    {
        $this->request = new FetchIssuersRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'apiKey' => 'mykey'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertEmpty($data);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('FetchIssuersSuccess.txt');
        $response = $this->request->send();
        $this->assertInstanceOf(FetchIssuersResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $expectedIssuer = new Issuer('INGBNL2A', 'Issuer Simulation V3 - ING', 'ideal');
        $this->assertEquals(array($expectedIssuer), $response->getIssuers());
    }
}
