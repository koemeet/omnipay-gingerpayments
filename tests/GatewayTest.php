<?php

namespace Omnipay\GingerPayments;

use Omnipay\GingerPayments\Message\CompletePurchaseRequest;
use Omnipay\GingerPayments\Message\FetchIssuersRequest;
use Omnipay\GingerPayments\Message\FetchTransactionRequest;
use Omnipay\GingerPayments\Message\PurchaseRequest;
use Omnipay\Tests\GatewayTestCase;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class GatewayTest extends GatewayTestCase
{
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testFetchIssuers()
    {
        $request = $this->gateway->fetchIssuers();

        $this->assertInstanceOf(FetchIssuersRequest::class, $request);
    }

    public function testFetchTransaction()
    {
        $request = $this->gateway->fetchTransaction(
            [
                'apiKey' => 'key',
                'transactionReference' => 'dbd10bc6-3c42-4731-ae0f-9dac7edb933b'
            ]
        );

        $this->assertInstanceOf(FetchTransactionRequest::class, $request);

        $data = $request->getData();
        $this->assertSame('dbd10bc6-3c42-4731-ae0f-9dac7edb933b', $data['id']);
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(['amount' => '10.00']);
        $this->assertInstanceOf(PurchaseRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testPurchaseReturn()
    {
        $request = $this->gateway->completePurchase(array('amount' => '10.00'));
        $this->assertInstanceOf(CompletePurchaseRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());
    }
}
