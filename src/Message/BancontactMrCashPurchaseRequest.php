<?php

namespace Omnipay\Buckaroo\Message;

/**
 * Buckaroo Bancontact Purchase Request
 */
class BancontactMrCashPurchaseRequest extends PurchaseRequest
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
