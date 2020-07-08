<?php

namespace Omnipay\Buckaroo\Message;

/**
 * Buckaroo Custom Gift Card Purchase Request
 */
class CustomGiftCardPurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        $data = parent::getData();

        $data['ContinueOnIncomplete'] = true;
        $data['Services'] = [
            'ServiceList' => [
                [
                    'Action' => 'Pay',
                    'Name' => 'customgiftcard',
                ]
            ]
        ];

        return $data;
    }
}
