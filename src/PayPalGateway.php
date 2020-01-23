<?php

namespace Omnipay\Buckaroo;

use Omnipay\Buckaroo\Message\PayPalPurchaseRequest;

/**
 * Buckaroo PayPal Gateway
 */
class PayPalGateway extends BuckarooGateway
{
    public function getName()
    {
        return 'Buckaroo PayPal';
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PayPalPurchaseRequest::class, $parameters);
    }
}
