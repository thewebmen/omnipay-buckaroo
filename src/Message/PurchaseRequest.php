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

        var_dump($httpResponse->getBody(true));
        die;

        parse_str($httpResponse->getBody(true), $body);

        return new PurchaseResponse($this, $body);
    }
}
