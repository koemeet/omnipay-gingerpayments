<?php

namespace Omnipay\GingerPayments\Message;

use Omnipay\Tests\TestCase;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class FetchTransactionRequestTest extends TestCase
{
    /**
     * @var FetchTransactionRequest
     */
    protected $request;

    public function setUp()
    {
        $this->request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'apiKey' => 'mykey',
                'transactionReference' => 'f46d6816-cffd-48cd-a05a-7bc447aad99c',
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame("f46d6816-cffd-48cd-a05a-7bc447aad99c", $data['id']);
        $this->assertCount(1, $data);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('FetchTransactionSuccess.txt');
        $response = $this->request->send();
        $this->assertInstanceOf(FetchTransactionResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isCompleted());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('completed', $response->getStatus());
        $this->assertSame('f46d6816-cffd-48cd-a05a-7bc447aad99c', $response->getTransactionReference());
        $this->assertSame(111, $response->getAmount());
    }

    public function testSendExpired()
    {
        $this->setMockHttpResponse('FetchTransactionExpired.txt');
        $response = $this->request->send();
        $this->assertInstanceOf(FetchTransactionResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('f46d6816-cffd-48cd-a05a-7bc447aad99c', $response->getTransactionReference());
        $this->assertTrue($response->isExpired());
    }
}
