<?php

namespace Omnipay\GingerPayments\Message;

use Omnipay\Common\Http\ResponseParser;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('apiKey', 'amount', 'description', 'returnUrl');

        $data = array();
        $data['amount'] = $this->getAmount();
        $data['description'] = $this->getDescription();
        $data['return_url'] = $this->getReturnUrl();

        $transaction = [];
        $transaction['payment_method'] = $this->getPaymentMethod();

        $issuer = $this->getIssuer();
        if ($issuer) {
            $transaction['payment_method_details'] = [
                'issuer_id' => $issuer
            ];
        }

        $data['transactions'] = [$transaction];

        $webhookUrl = $this->getNotifyUrl();
        if (null !== $webhookUrl) {
            $data['webhook_url'] = $webhookUrl;
        }

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('POST', '/orders/', $data);

        return $this->response = new PurchaseResponse($this, ResponseParser::json($httpResponse));
    }
}
