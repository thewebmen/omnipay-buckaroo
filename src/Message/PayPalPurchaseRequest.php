<?php

namespace Omnipay\Buckaroo\Message;

/**
 * Buckaroo PayPal Purchase Request
 */
class PayPalPurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = parent::getData();

        $data['Services'] = [
            'ServiceList' => [
                [
                    'Action' => 'Pay',
                    'Name' => 'paypal',
                ]
            ]
        ];

        return $data;
    }
}
