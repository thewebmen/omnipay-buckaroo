<?php

namespace Omnipay\Buckaroo\Message;

/**
 * Buckaroo Purchase Request.
 *
 * With this purchase request Buckaroo will show all payment options configured for the website (websiteKey).
 * The user must choose the payment method on the Buckaroo page.
 */
class PurchaseRequest extends AbstractRequest
{
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('POST', 'Transaction', $data);

        $data = json_decode($httpResponse->getBody());

        return new PurchaseResponse($this, $data);
    }

    public function getHeaders()
    {
        $headers = parent::getHeaders();

        $headers['culture'] = $this->getCulture();

        return $headers;
    }

    public function getData()
    {
        $data = parent::getData();

        $data['ContinueOnIncomplete'] = 1;
        
        if ($this->getPaymentMethod()) {
            $data['Services'] = [
                'ServiceList' => [
                    [
                        'Action' => 'Pay',
                        'Name' => $this->getPaymentMethod(),
                        'Parameters' => [
                            'Name' => 'issuer',
                            'Value' => $this->getIssuer()
                        ]
                    ]
                ]
            ];
        }

        return $data;
    }
}
