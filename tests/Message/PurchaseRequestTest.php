<?php

namespace Omnipay\GingerPayments\Message;

use Omnipay\Tests\TestCase;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class PurchaseRequestTest extends TestCase
{
    /**
     *
     * @var PurchaseRequest
     */
    protected $request;

    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'apiKey' => 'mykey',
            'amount' => '12.00',
            'issuer' => 'my bank',
            'description' => 'Description',
            'returnUrl' => 'https://www.example.com/return',
            'method' => 'ideal',
            'metadata' => 'meta',
        ));
    }

    public function testGetData()
    {
        $this->request->initialize(array(
            'apiKey' => 'mykey',
            'amount' => '12.00',
            'description' => 'Description',
            'returnUrl' => 'https://www.example.com/return',
            'paymentMethod' => 'ideal',
            'metadata' => 'meta',
            'issuer' => 'my bank',
        ));

        $data = $this->request->getData();

        $this->assertSame('12.00', $data['amount']);
        $this->assertSame('Description', $data['description']);
        $this->assertSame('https://www.example.com/return', $data['return_url']);
        $this->assertSame('ideal', $data['transactions'][0]['payment_method']);
        $this->assertSame('my bank', $data['transactions'][0]['payment_method_details']['issuer_id']);
    }

    public function testGetDataWithWebhook()
    {
        $this->request->initialize(array(
            'apiKey' => 'mykey',
            'amount' => '12.00',
            'description' => 'Description',
            'returnUrl' => 'https://www.example.com/return',
            'paymentMethod' => 'ideal',
            'metadata' => 'meta',
            'issuer' => 'my bank',
            'notifyUrl' => 'https://www.example.com/hook',
        ));

        $data = $this->request->getData();

        $this->assertSame('12.00', $data['amount']);
        $this->assertSame('Description', $data['description']);
        $this->assertSame('https://www.example.com/return', $data['return_url']);
        $this->assertSame('ideal', $data['transactions'][0]['payment_method']);
        $this->assertSame('my bank', $data['transactions'][0]['payment_method_details']['issuer_id']);
        $this->assertSame('https://www.example.com/hook', $data['webhook_url']);
    }

    public function testNoIssuer()
    {
        $this->request->initialize(array(
            'apiKey' => 'mykey',
            'amount' => '12.00',
            'description' => 'Description',
            'returnUrl' => 'https://www.example.com/return',
            'paymentMethod' => 'ideal',
            'metadata' => 'meta',
            'notifyUrl' => 'https://www.example.com/hook',
        ));

        $data = $this->request->getData();

        $this->assertSame('12.00', $data['amount']);
        $this->assertSame('Description', $data['description']);
        $this->assertSame('https://www.example.com/return', $data['return_url']);
        $this->assertSame('ideal', $data['transactions'][0]['payment_method']);
        $this->assertSame('https://www.example.com/hook', $data['webhook_url']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        /** @var PurchaseResponse $response */
        $response = $this->request->send();

        $this->assertInstanceOf(PurchaseResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertSame('GET', $response->getRedirectMethod());
        $this->assertSame('https://api.gingerpayments.com/redirect/4945b425-1757-4987-bba8-42487a332543/to/payment/', $response->getRedirectUrl());
        $this->assertNull($response->getRedirectData());
        $this->assertSame('c69d0d52-be19-4c50-83dc-6acbb53d74b1', $response->getTransactionReference());
        $this->assertTrue($response->isNew());
        $this->assertFalse($response->isCompleted());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
    }
}