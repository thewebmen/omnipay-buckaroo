<?php

namespace Omnipay\Buckaroo\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Buckaroo iDeal Purchase Request
 */
class IdealPurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        $data = parent::getData();
        
        $data['Brq_payment_method'] = 'ideal';
        $data['Brq_service_ideal_issuer'] = $this->getIssuer() ?: '';

        return $data;
    }

    public function validate()
    {
        parent::validate();

        if (!$this->getIssuer()) {
            throw new InvalidRequestException("The issuer parameter is required");
        }
    }
}
