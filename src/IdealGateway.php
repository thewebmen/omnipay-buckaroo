<?php

namespace Omnipay\Buckaroo;

use Omnipay\Buckaroo\Message\IdealPurchaseRequest;

/**
 * Buckaroo iDeal Gateway
 */
class IdealGateway extends BuckarooGateway
{
    public function getName()
    {
        return 'Buckaroo iDeal';
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(IdealPurchaseRequest::class, $parameters);
    }
}
