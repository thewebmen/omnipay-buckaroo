<?php

namespace Omnipay\Buckaroo;

use Omnipay\Buckaroo\Message\BancontactMrCashPurchaseRequest;

/**
 * Buckaroo BancontactMrCash Gateway
 */
class BancontactMrCashGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Buckaroo BancontactMrCash';
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest(BancontactMrCashPurchaseRequest::class, $parameters);
    }
}
