<?php

namespace Omnipay\Buckaroo\Message;

use Guzzle\Http\Message\Response;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * Buckaroo Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @var string
     */
    protected $testEndpoint = 'testcheckout.buckaroo.nl/json/';

    /**
     * @var string
     */
    protected $liveEndpoint = 'checkout.buckaroo.nl/json/';

    /**
     * @return mixed
     */
    public function getWebsiteKey()
    {
        return $this->getParameter('websiteKey');
    }

    /**
     * @return mixed
     */
    public function setWebsiteKey($value)
    {
        return $this->setParameter('websiteKey', $value);
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * @return mixed
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * @return mixed
     */
    public function getCulture()
    {
        return $this->getParameter('culture');
    }

    /**
     * @return mixed
     */
    public function setCulture($value)
    {
        return $this->setParameter('culture', $value);
    }

    /**
     * @return string url rejectUrl
     */
    public function getRejectUrl()
    {
        return $this->getParameter('rejectUrl');
    }

    /**
     * sets the Reject URL which is used by buckaroo when
     * the payment is rejected.
     *
     * @param $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setRejectUrl($value)
    {
        return $this->setParameter('rejectUrl', $value);
    }

    /**
     * returns the error URL
     *
     * @return string errorUrl
     */
    public function getErrorUrl()
    {
        return $this->getParameter('errorUrl');
    }

    /**
     * sets the error URL which is used by buckaroo when
     * the payment results in an error
     *
     * @param $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setErrorUrl($value)
    {
        return $this->setParameter('errorUrl', $value);
    }

    /**
     * returns the push URL
     *
     * @return string pushUrl
     */
    public function getPushUrl()
    {
        return $this->getParameter('pushUrl');
    }

    /**
     * sets the push URL which is used by buckaroo when
     * the payment results is sent via push
     *
     * @param $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setPushUrl($value)
    {
        return $this->setParameter('pushUrl', $value);
    }

    /**
     * returns the push failure URL
     *
     * @return string pushfailureUrl
     */
    public function getPushFailureUrl()
    {
        return $this->getParameter('pushfailureUrl');
    }

    /**
     * sets the push failure URL which is used by buckaroo when
     * the payment error results is sent via push
     *
     * @param $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setPushFailureUrl($value)
    {
        return $this->setParameter('pushfailureUrl', $value);
    }

    /**
     * @return array
     */
    public function getData()
    {
        $this->validate('websiteKey', 'secretKey', 'amount', 'returnUrl');

        $data = [];
        $data['Currency'] = $this->getCurrency();
        $data['AmountDebit'] = $this->getAmount();
        $data['Invoice'] = $this->getTransactionId();
        $data['Description'] = $this->getDescription();

        $data['ReturnURL'] = $this->getReturnUrl();
        $data['ReturnURLCancel'] = $this->getCancelUrl();
        $data['ReturnURLError'] = $this->getErrorUrl();
        $data['ReturnURLReject'] = $this->getRejectUrl();
        $data['PushURL'] = $this->getPushUrl();
        $data['PushURLFailure'] = $this->getPushFailureUrl();

        return $data;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * @param array $data
     * @return string
     */
    public function generateSignature($data)
    {
        uksort($data, 'strcasecmp');

        $str = '';
        foreach ($data as $key => $value) {
            if ($key == 'brq_signature') {
                continue;
            }
            $str .= $key.'='.urldecode($value);
        }

        return sha1($str.$this->getSecretKey());
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array|null $data
     * @return string
     */
    public function generateAuthorizationHeader($method, $endpoint, array $data = null)
    {
        $url = strtolower(urlencode($this->getEndpoint() . $endpoint));
        $time = time();
        $nonce = 'nonce_' . rand(0000000, 9999999);
        $post = base64_encode(md5(json_encode($data), true));
        $value = $this->getWebsiteKey() . $method . $url . $time . $nonce . $post;
        $hmac = base64_encode(hash_hmac('sha256', $value, $this->getSecretKey(),true));

        return 'hmac ' . $this->getWebsiteKey() . ':' . $hmac . ':' . $nonce . ':' . $time;
    }

    /**
     * @param mixed $data
     * @return \Omnipay\Common\Message\ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * Execute the Guzzle request.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @return ResponseInterface
     */
    protected function sendRequest($method, $endpoint, array $data)
    {
        $headers = array_merge($this->getHeaders(), [
            'Authorization' => $this->generateAuthorizationHeader($method, $endpoint, $data)
        ]);

        return $this->httpClient->request(
            $method,
            'https://' . $this->getEndpoint() . $endpoint,
            $headers,
            json_encode($data)
        );
    }
}
