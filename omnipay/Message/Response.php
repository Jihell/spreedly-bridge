<?php

namespace Omnipay\SpreedlyBridge\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

class Response extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * Response constructor.
     *
     * @param RequestInterface $request
     * @param                  $data
     * @param int              $statusCode
     */
    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data ? $data['transaction']['response']['body'] : $data);

        $this->statusCode = $statusCode;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        list( $first, $second, ) = explode('.', (string) $this->data['result']['code']);

        return ! $this->isRedirect() && ! $this->isPending()
            && $this->getCode() < 400 && $first == '000' && $second < '200';
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return isset($this->data['redirect']['url']);
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return isset($this->data['result']['code']) && substr($this->data['result']['code'], 0, 7) == '000.200';
    }

    /**
     * @return string|null
     */
    public function getTransactionReference()
    {
        if (isset($this->data['id'])) {
            return $this->data['id'];
        }
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        if (isset($this->data['merchantTransactionId'])) {
            return $this->data['merchantTransactionId'];
        }
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return $this->data['redirect']['url'];
        }
    }

    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * @return array
     */
    public function getRedirectData()
    {
        $list = [];

        foreach ($this->data['redirect']['parameters'] as $pair) {
            $list[$pair['name']] = $pair['value'];
        }

        return  $list;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        if (isset($this->data['result']['description'])) {
            return $this->data['result']['description'];
        }

        return null;
    }

    /**
     * @return int|string|null
     */
    public function getCode()
    {
        return $this->statusCode;
    }
}
