<?php

namespace Omnipay\Buckaroo\Message;

/**
 * Buckaroo Credit Card Purchase Request
 */
class CreditCardPurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        $data = parent::getData();

        $data['Services'] = [
            'ServiceList' => [
                [
                    'Action' => 'Pay',
                    'Name' => $this->getPaymentMethod(),
                ]
            ]
        ];

        return $data;
    }
}
