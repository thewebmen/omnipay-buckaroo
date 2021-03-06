<?php

namespace Omnipay\Buckaroo;

use Omnipay\Buckaroo\Message\CompletePurchaseRequest;
use Omnipay\Buckaroo\Message\PurchaseRequest;

/**
 * Buckaroo Abstract Gateway
 */
abstract class AbstractGateway extends \Omnipay\Common\AbstractGateway
{
    public function getDefaultParameters()
    {
        return array(
            'websiteKey' => '',
            'secretKey' => '',
            'testMode' => false,
        );
    }

    public function getWebsiteKey()
    {
        return $this->getParameter('websiteKey');
    }

    public function setWebsiteKey($value)
    {
        return $this->setParameter('websiteKey', $value);
    }

    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }
}
