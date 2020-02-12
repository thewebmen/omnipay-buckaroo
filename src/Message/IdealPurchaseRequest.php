<?php

namespace Omnipay\Buckaroo\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Buckaroo iDeal Purchase Request
 */
class IdealPurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        $data = parent::getData();

        $data['Services'] = [
            'ServiceList' => [
                [
                    'Action' => 'Pay',
                    'Name' => 'ideal'
                ]
            ]
        ];
        
        if ($this->getIssuer()) {
            $data['Services']['ServiceList'][0]['Parameters'] = [
                'Name' => 'issuer',
                'Value' => $this->getIssuer()
            ];
        } else {
            $data['ContinueOnIncomplete'] = 1;
        }

        return $data;
    }
}
