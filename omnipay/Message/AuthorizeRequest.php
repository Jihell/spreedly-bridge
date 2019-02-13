<?php
/**
 * @licence Proprietary
 */
namespace Omnipay\SpreedlyBridge\Message;

/**
 * Class AuthorizeRequest
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class AuthorizeRequest extends AbstractRequest
{
    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->getBridge()->authorize([
            'bin' => $this->getBin(),
            'landingUrl' => $this->getLandingUrl(),
        ]);
    }
}
