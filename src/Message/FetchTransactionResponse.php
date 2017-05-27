<?php

namespace Omnipay\GingerPayments\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class FetchTransactionResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * {@inheritdoc}
     */
    public function isRedirect()
    {
        if (isset($this->data['transactions']) && isset($this->data['transactions'][0]['payment_url'])) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return $this->data['transactions'][0]['payment_url'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectData()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return parent::isSuccessful();
    }

    /**
     * @return boolean
     */
    public function isNew()
    {
        return isset($this->data['status']) && 'new' === $this->data['status'];
    }

    /**
     * @return boolean
     */
    public function isProcessing()
    {
        return isset($this->data['status']) && 'processing' === $this->data['status'];
    }

    /**
     * @return boolean
     */
    public function isError()
    {
        return isset($this->data['status']) && 'error' === $this->data['status'];
    }

    /**
     * @return boolean
     */
    public function isCancelled()
    {
        return isset($this->data['status']) && 'cancelled' === $this->data['status'];
    }

    /**
     * @return boolean
     */
    public function isCompleted()
    {
        return isset($this->data['status']) && 'completed' === $this->data['status'];
    }

    /**
     * @return boolean
     */
    public function isExpired()
    {
        return isset($this->data['status']) && 'expired' === $this->data['status'];
    }

    /**
     * @return mixed
     */
    public function getTransactionReference()
    {
        if (isset($this->data['id'])) {
            return $this->data['id'];
        }
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->getTransactionReference();
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        if (isset($this->data['status'])) {
            return $this->data['status'];
        }
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        if (isset($this->data['amount'])) {
            return (int)$this->data['amount'] / 100;
        }
    }
}
