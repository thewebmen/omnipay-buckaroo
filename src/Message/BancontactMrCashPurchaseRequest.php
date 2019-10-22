<?php

namespace Omnipay\Buckaroo\Message;

class BancontactMrCashPurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = parent::getData();
        $data['Brq_payment_method'] = 'bancontactmrcash';
        return $data;
    }
}
