<?php
/**
 * @licence Proprietary
 */
namespace Omnipay\SpreedlyBridge\Exception;

use Throwable;

/**
 * Class MustProvideReceiverException
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class MustProvideReceiverException extends \Exception
{
    /**
     * MustProvideReceiverException constructor.
     *
     * @param Throwable|null $previous
     */
    public function __construct(Throwable $previous = null)
    {
        parent::__construct(
            'You must provide a \'receiver\' instance of ReceiverInterface to options',
            '400.400',
            $previous
        );
    }
}
