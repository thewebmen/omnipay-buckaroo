<?php

namespace Omnipay\Buckaroo\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Buckaroo Complete Purchase Response
 */
class CompletePurchaseResponse extends AbstractResponse
{
    const SUCCESS = '190';

    public function isSuccessful()
    {
        return self::SUCCESS === $this->getCode();
    }

    public function getCode()
    {
        if (isset($this->data['brq_statuscode'])) {
            return $this->data['brq_statuscode'];
        }
    }

    public function getMessage()
    {
        if (isset($this->data['brq_statusmessage'])) {
            return $this->data['brq_statusmessage'];
        }
    }

    public function getTransactionReference()
    {
        if (isset($this->data['brq_payment'])) {
            return $this->data['brq_payment'];
        }
    }

    public function getTransactionId()
    {
        if (isset($this->data['brq_invoicenumber'])) {
            return $this->data['brq_invoicenumber'];
        }
    }
}
