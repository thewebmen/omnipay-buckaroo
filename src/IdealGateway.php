<?php

namespace Omnipay\Buckaroo;

use Omnipay\Buckaroo\Message\IdealPurchaseRequest;

/**
 * Buckaroo iDeal Gateway
 */
class IdealGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Buckaroo iDeal';
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest(IdealPurchaseRequest::class, $parameters);
    }
}
