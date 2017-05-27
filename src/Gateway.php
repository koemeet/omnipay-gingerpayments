<?php

namespace Omnipay\GingerPayments;

use Omnipay\Common\AbstractGateway;
use Omnipay\GingerPayments\Message\CompletePurchaseRequest;
use Omnipay\GingerPayments\Message\FetchIssuersRequest;
use Omnipay\GingerPayments\Message\FetchTransactionRequest;
use Omnipay\GingerPayments\Message\PurchaseRequest;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'GingerPayments';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return array(
            'apiKey' => ''
        );
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @param array $parameters
     *
     * @return FetchIssuersRequest
     */
    public function fetchIssuers(array $parameters = array())
    {
        return $this->createRequest(FetchIssuersRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return FetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest(FetchTransactionRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }
    /**
     * @param  array $parameters
     *
     * @return CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }
}
