<?php
/**
 * @licence Proprietary
 */
namespace Omnipay\SpreedlyBridge\Model;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Interface ReceiverAdapterInterface
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface ReceiverBridgeInterface
{
    /**
     * @param bool $mode
     * @return $this
     */
    public function setTestMode($mode);

    /**
     * @param RequestInterface $request
     * @param                  $data
     * @param int              $statusCode
     * @return AbstractResponse
     */
    public function createResponse(RequestInterface $request, $data, $statusCode = 200);

    /**
     * Return an array with url and body content
     *
     * @return array
     */
    function authorize(array $options = []);

    /**
     * @param array $options
     * @return mixed
     */
    function completeAuthorize(array $options = []);

    /**
     * Return an array with url and body content
     *
     * @return array
     */
    function purchase(array $options = []);

    /**
     * @param array $options
     * @return mixed
     */
    function completePurchase(array $options = []);
}
