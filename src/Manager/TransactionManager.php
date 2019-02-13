<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Jihel\OmnipaySpreedlyBridgeBundle\Entity\Credit;
use Jihel\OmnipaySpreedlyBridgeBundle\Entity\Payment;
use Jihel\OmnipaySpreedlyBridgeBundle\Entity\Transaction;
use ColinODell\OmnipayBundle\Service\Omnipay;
use Jihel\OmnipaySpreedlyBridgeBundle\Model\CreditInterface;
use Jihel\OmnipaySpreedlyBridgeBundle\Model\PaymentInterface;
use Jihel\OmnipaySpreedlyBridgeBundle\Model\PaymentRequest;
use Jihel\OmnipaySpreedlyBridgeBundle\Model\TransactionInterface;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\SpreedlyBridge\Gateway;
use Omnipay\SpreedlyBridge\Model\ReceiverInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class TransactionManager
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class TransactionManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var Gateway
     */
    protected $gateway;

    /**
     * @var CreditCardManager
     */
    protected $creditCardManager;

    /**
     * TransactionManager constructor.
     *
     * @param EntityManagerInterface   $manager
     * @param EventDispatcherInterface $eventDispatcher
     * @param Omnipay                  $omnipay
     * @param CreditCardManager        $creditCardManager
     */
    public function __construct(
        EntityManagerInterface $manager,
        EventDispatcherInterface $eventDispatcher,
        Omnipay $omnipay,
        CreditCardManager $creditCardManager
    ) {
        $this->manager = $manager;
        $this->eventDispatcher = $eventDispatcher;
        $this->gateway = $omnipay->get(Gateway::NAME);
        $this->creditCardManager = $creditCardManager;
    }

    /**
     * @param PaymentRequest    $paymentRequest
     * @param ReceiverInterface $receiver
     * @param bool              $persist
     * @return Transaction
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Omnipay\SpreedlyBridge\Exception\CreateReceiverException
     */
    public function create(PaymentRequest $paymentRequest, ReceiverInterface $receiver, $persist = true)
    {
        $transaction = new Transaction();
        $transaction
            ->setReceiver($receiver)
            ->setAmount($paymentRequest->getAmount())
            ->setCurrency($paymentRequest->getCurrency())
        ;

        if ($persist) {
            $this->manager->persist($transaction);
            $this->manager->flush();
        }

        return $transaction;
    }

    /**
     * @param TransactionInterface $transaction
     * @return $this
     */
    public function proceedPayment(PaymentRequest $paymentRequest, TransactionInterface $transaction, $persist = true)
    {
        $creditCard = $this->creditCardManager->create($paymentRequest->getToken());

        $transaction
            ->setState(TransactionInterface::STATE_PROCESSING)
            ->setCreditCard($creditCard)
        ;

        if ($persist) {
            $this->manager->persist($transaction);
            $this->manager->flush();
        }

        return $this;
    }

    /**
     * @param TransactionInterface $transaction
     * @return PaymentInterface
     */
    public function createPayment(TransactionInterface $transaction)
    {
        // Fetch pending payment
        if ($transaction->getPayments()->last()
         && $transaction->getPayments()->last()->getState() === PaymentInterface::STATE_NEW
        ) {
            return $transaction->getPayments()->last();
        }

        // Create payment
        $payment = new Payment();
        $payment->setAmount($transaction->getAmount());
        $transaction
            ->addPayment($payment)
            ->setState(TransactionInterface::STATE_PROCESSING)
        ;

        $this->manager->persist($transaction);
        $this->manager->flush();

        return $payment;
    }

    /**
     * @param TransactionInterface $transaction
     * @return CreditInterface
     */
    public function createCredit(PaymentInterface $payment)
    {
        // Fetch pending payment
        if ($payment->getCredits()->last()
         && $payment->getCredits()->last()->getState() === PaymentInterface::STATE_NEW
        ) {
            return $payment->getCredits()->last();
        }

        // Create payment
        $credit = new Credit();
        $credit->setAmount($payment->getAmountDeposited());
        $credit
            ->setTransaction($payment->getTransaction())
            ->setPayment($payment)
        ;

        $this->manager->persist($credit);
        $this->manager->flush();

        return $credit;
    }

    /**
     * @param PaymentInterface $payment
     * @return $this
     */
    public function failPayment(PaymentInterface $payment)
    {
        $payment->getTransaction()->setState(TransactionInterface::STATE_DECLINED);
        $payment->setState(PaymentInterface::STATE_FAILED);

        $this->manager->persist($payment->getTransaction());
        $this->manager->persist($payment);
        $this->manager->flush();

        return $this;
    }

    /**
     * @param PaymentInterface $payment
     * @return $this
     */
    public function pendingPayment(PaymentInterface $payment)
    {
        $payment->setState(PaymentInterface::STATE_PENDING);

        $this->manager->persist($payment);
        $this->manager->flush();

        return $this;
    }

    /**
     * @param PaymentInterface $payment
     * @param null|string      $token
     * @return $this
     */
    public function authorizePayment(PaymentInterface $payment, ResponseInterface $response)
    {
        $transaction = $payment->getTransaction();
        $transaction->setState(TransactionInterface::STATE_AUTHORIZED);
        $payment->setState(PaymentInterface::STATE_AUTHORIZED);

        // Amount is now authorized
        $payment->setAmountAuthorized($payment->getAmount());
        $payment->setAmount(0);
        $transaction->setAmountAuthorized($transaction->getAmountAuthorized() + $payment->getAmountAuthorized());
        $transaction->setAmount(0);

        // Fill with response
        if ($response->getTransactionReference()) {
            $transaction->setToken($response->getTransactionReference());
        }
        $payment->setDescriptor($response->getDescriptor());
        $payment->setReference($response->getTransactionId());

        $this->manager->persist($transaction);
        $this->manager->persist($payment);
        $this->manager->flush();

        return $this;
    }

    /**
     * @param PaymentInterface  $payment
     * @param ResponseInterface $response
     * @return $this
     */
    public function depositPayment(PaymentInterface $payment, ResponseInterface $response)
    {
        $transaction = $payment->getTransaction();
        $transaction->setState(TransactionInterface::STATE_AUTHORIZED);
        $payment->setState(PaymentInterface::STATE_DEPOSITED);

        if ($payment->getAmount()) {
            $payment->setAmountAuthorized($payment->getAmountAuthorized() + $payment->getAmount());
            $payment->setAmount(0);
        }

        // Amount is now authorized
        $payment->setAmountDeposited($payment->getAmountAuthorized());
        $transaction->setAmountDeposited($transaction->getAmountDeposited() + $payment->getAmountDeposited());

        // Fill with response
        if ($response->getTransactionReference()) {
            $transaction->setToken($response->getTransactionReference());
        }
        $payment->setDescriptor($response->getDescriptor());
        if (!$payment->getReference()) {
            $payment->setReference($response->getTransactionId());
        }

        $this->manager->persist($transaction);
        $this->manager->persist($payment);
        $this->manager->flush();

        return $this;
    }

    /**
     * @param PaymentInterface  $payment
     * @param CreditInterface   $credit
     * @param ResponseInterface $response
     * @return $this
     */
    public function creditPayment(PaymentInterface $payment, CreditInterface $credit, ResponseInterface $response)
    {
        $transaction = $payment->getTransaction();
        $payment->setState(PaymentInterface::STATE_CREDITED);

        // Amount is now credited
        $payment->setAmountCredited($payment->getAmountCredited() + $credit->getAmount());
        $payment->setAmountDeposited($payment->getAmountDeposited() - $credit->getAmount());
        $credit->setAmountCredited($credit->getAmountCredited() + $credit->getAmount());
        $credit->setState(CreditInterface::STATE_CREDITED);

        $transaction->setAmountCredited($transaction->getAmountCredited() + $credit->getAmountCredited());
        $transaction->setAmountDeposited($transaction->getAmountDeposited() - $credit->getAmountCredited());

        $credit->setReference($response->getTransactionId());

        $this->manager->persist($transaction);
        $this->manager->persist($payment);
        $this->manager->persist($credit);
        $this->manager->flush();

        return $this;
    }
}
