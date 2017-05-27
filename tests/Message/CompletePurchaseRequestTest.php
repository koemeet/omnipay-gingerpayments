<?php

namespace Omnipay\GingerPayments\Message;

use Omnipay\Tests\TestCase;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class CompletePurchaseRequestTest extends TestCase
{
    /**
     * @var CompletePurchaseRequest
     */
    protected $request;

    public function setUp()
    {
        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'apiKey' => 'mykey',
        ));

        $this->getHttpRequest()->request->replace(array(
            'id' => 'f46d6816-cffd-48cd-a05a-7bc447aad99c',
        ));
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage The transactionReference parameter is required
     */
    public function testGetDataWithoutIDParameter()
    {
        $this->getHttpRequest()->request->remove('id');

        $data = $this->request->getData();

        $this->assertEmpty($data);
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame("f46d6816-cffd-48cd-a05a-7bc447aad99c", $data['id']);
        $this->assertCount(1, $data);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');
        $response = $this->request->send();

        $this->assertInstanceOf(CompletePurchaseResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isNew());
        $this->assertTrue($response->isCompleted());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('f46d6816-cffd-48cd-a05a-7bc447aad99c', $response->getTransactionReference());
    }

    public function testSendExpired()
    {
        $this->setMockHttpResponse('CompletePurchaseExpired.txt');
        $response = $this->request->send();

        $this->assertInstanceOf(CompletePurchaseResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isCompleted());
        $this->assertTrue($response->isExpired());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('f46d6816-cffd-48cd-a05a-7bc447aad99c', $response->getTransactionReference());
    }
}
