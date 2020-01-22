<?php

namespace Omnipay\Buckaroo\Message;

use Omnipay\Common\Exception\RuntimeException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use SilverStripe\Omnipay\Model\Message\PurchaseRedirectResponse;
use Symfony\Component\HttpFoundation\RedirectResponse as HttpRedirectResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Buckaroo Purchase Response
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return isset($this->data['BRQ_REDIRECTURL']);
    }

    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return $this->data['BRQ_REDIRECTURL'];
        }

        return $this->getRequest()->getEndpoint();
    }

    public function getRedirectMethod()
    {
        return isset($this->data['BRQ_REDIRECTURL']) ? 'GET' : 'POST';
    }

    public function getRedirectData()
    {
        return $this->data;
    }

    public function getMessage()
    {
        return isset($this->data['BRQ_APIERRORMESSAGE']) ? $this->data['BRQ_APIERRORMESSAGE'] : null;
    }
}
