<?php

namespace Omnipay\Buckaroo;

class BancontactMrCashGateway extends CreditCardGateway
{
    public function getName()
    {
        return 'Buckaroo Bancontact MrCash';
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Buckaroo\Message\BancontactMrCashPurchaseRequest', $parameters);
    }
}
