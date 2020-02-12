<?php

namespace Omnipay\Buckaroo;

use Omnipay\Buckaroo\Message\CreditCardPurchaseRequest;

/**
 * Buckaroo Credit Card Gateway
 */
class CreditCardGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Buckaroo Creditcard';
    }

    public function getPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }

    public function setPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(CreditCardPurchaseRequest::class, $parameters);
    }
}
