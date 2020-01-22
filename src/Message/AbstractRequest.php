<?php

namespace Omnipay\Buckaroo\Message;

use Guzzle\Http\Message\Response;

/**
 * Buckaroo Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @var string
     */
    protected $testEndpoint = 'https://testcheckout.buckaroo.nl/json/';

    /**
     * @var string
     */
    protected $liveEndpoint = 'https://checkout.buckaroo.nl/json/';

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
     * @return []
     */
    public function getData()
    {
        $this->validate('websiteKey', 'secretKey', 'amount', 'returnUrl');

        $data = array();
        $data['Brq_websitekey'] = $this->getWebsiteKey();
        $data['Brq_amount'] = $this->getAmount();
        $data['Brq_currency'] = $this->getCurrency();
        $data['Brq_invoicenumber'] = $this->getTransactionId();
        $data['Brq_description'] = $this->getDescription();
        $data['Brq_return'] = $this->getReturnUrl();
        $data['Brq_returncancel'] = $this->getCancelUrl();
        $data['Brq_returnreject'] = $this->getRejectUrl();
        $data['Brq_returnerror'] = $this->getErrorUrl();
        $data['Brq_culture'] = $this->getCulture();
        $data['Brq_push'] = $this->getPushUrl();
        $data['Brq_pushfailure'] = $this->getPushFailureUrl();

        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array|null $data
     * @return string
     */
    public function generateAuthorizationHeader($method, $endpoint, array $data = null)
    {
        $time = time();
        $nonce = 'nonce_' . rand(0000000, 9999999);
        $post = base64_decode(md5(json_encode($data), true));
        $value = $this->getWebsiteKey() . $method . $this->getEndpoint() . $endpoint . $time . $nonce . $post;
        $hmac = hash_hmac('sha256', $value, $this->getSecretKey(),true);

        return 'hmac ' . $this->getWebsiteKey() . ':' . base64_encode($hmac) . ':' . $nonce . ':' . $time;
    }

    /**
     * @param mixed $data
     * @return \Omnipay\Common\Message\ResponseInterface
     */
    public function sendData($data)
    {
        $data['Brq_signature'] = $this->generateSignature($data);

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
     * @param array $data|null
     * @return Response
     */
    protected function sendRequest($method, $endpoint, array $data = null)
    {

        return $this->httpClient->createRequest(
            $method,
            $this->getEndpoint() . $endpoint,
            [
                'json' => $data,
                'Authorization' => $this->generateAuthorizationHeader($method, $endpoint, $data)
            ]
        )->send();
    }
}
