<?php

namespace Omnipay\GingerPayments\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Http\ResponseParser;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class CompletePurchaseRequest extends FetchTransactionRequest
{
    public function getData()
    {
        $this->validate('apiKey');
        $data = array();
        $data['id'] = $this->getTransactionReference();

        if (!isset($data['id'])) {
            $data['id'] = $this->httpRequest->request->get('id');
        }

        if (empty($data['id'])) {
            throw new InvalidRequestException("The transactionReference parameter is required");
        }

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('GET', 'orders/' . $data['id']);

        $tan = $httpResponse->getBody(true);

        return $this->response = new CompletePurchaseResponse($this, $httpResponse->json());
    }
}
