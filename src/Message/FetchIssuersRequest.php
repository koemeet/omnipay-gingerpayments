<?php

namespace Omnipay\GingerPayments\Message;

use Omnipay\Common\Http\ResponseParser;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class FetchIssuersRequest extends AbstractRequest
{
    /**
     * @return null
     */
    public function getData()
    {
        $this->validate('apiKey');
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('GET', '/ideal/issuers');

        return $this->response = new FetchIssuersResponse($this, ResponseParser::json($httpResponse));
    }
}
