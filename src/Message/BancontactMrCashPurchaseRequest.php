<?php

namespace Omnipay\Buckaroo\Message;

class BancontactMrCashPurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = parent::getData();

        $data['Services'] = [
            'ServiceList' => [
                [
                    'Action' => 'Pay',
                    'Name' => 'bancontactmrcash',
                ]
            ]
        ];
        
        return $data;
    }
}
