<?php

namespace Omnipay\GingerPayments\Message;

use Guzzle\Common\Event;

/**
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = 'https://api.gingerpayments.com/v1/';

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function setTransactionId($value)
    {
        return $this->setParameter('transactionId', $value);
    }

    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }

    protected function sendRequest($method, $endpoint, $data = null)
    {
        $this->httpClient->getEventDispatcher()->addListener('request.error', function (Event $event) {
            /**
             * @var \Guzzle\Http\Message\Response $response
             */
            $response = $event['response'];

            if ($response->isError()) {
                $event->stopPropagation();
            }
        });

        $credentials = base64_encode($this->getApiKey() . ':');

        $headers = [
            'Authorization' => 'Basic ' . $credentials,
        ];

        $body = null;

        if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
            $body = json_encode($data);
            $headers['Content-Type'] = 'application/json';
        }

        $httpRequest = $this->httpClient->createRequest(
            $method,
            $this->endpoint . $endpoint,
            $headers,
            $body
        );

        return $httpRequest->send();
    }
}
