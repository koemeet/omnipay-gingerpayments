<?php

namespace Omnipay\GingerPayments\Message;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return !$this->isRedirect() && !isset($this->data['error']);
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        if (isset($this->data['error'])) {
            return $this->data['error']['message'];
        }
    }
}