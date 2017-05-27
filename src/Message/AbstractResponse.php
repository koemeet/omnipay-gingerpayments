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
        return "Something went wrong.";
    }
}