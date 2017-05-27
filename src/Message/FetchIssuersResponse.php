<?php

namespace Omnipay\GingerPayments\Message;

use Omnipay\Common\Issuer;
use Omnipay\Common\Message\FetchIssuersResponseInterface;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class FetchIssuersResponse extends AbstractResponse implements FetchIssuersResponseInterface
{
    /**
     * @return Issuer[]
     */
    public function getIssuers()
    {
        if (isset($this->data)) {
            $issuers = array();

            foreach ($this->data as $issuer) {
                $issuers[] = new Issuer($issuer['id'], $issuer['name'], 'ideal');
            }

            return $issuers;
        }
    }
}
