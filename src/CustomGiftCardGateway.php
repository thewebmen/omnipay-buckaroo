<?php

namespace Omnipay\Buckaroo;

use Omnipay\Buckaroo\Message\CustomGiftCardPurchaseRequest;

/**
 * Buckaroo Custom Gift Card Gateway
 */
class CustomGiftCardGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Buckaroo Custom Gift Card';
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(CustomGiftCardPurchaseRequest::class, $parameters);
    }
}
