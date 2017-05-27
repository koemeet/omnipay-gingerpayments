<?php

namespace Omnipay\GingerPayments\Message;

use Omnipay\Common\Http\ResponseParser;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('apiKey', 'transactionReference');
        $data = array();
        $data['id'] = $this->getTransactionReference();
        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('GET', '/orders/' . $data['id']);
        return $this->response = new FetchTransactionResponse($this, ResponseParser::json($httpResponse));
    }
}
