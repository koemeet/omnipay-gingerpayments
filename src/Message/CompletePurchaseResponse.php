<?php

namespace Omnipay\GingerPayments\Message;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class CompletePurchaseResponse extends FetchTransactionResponse
{
    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return parent::isSuccessful() && $this->isCompleted();
    }
}
