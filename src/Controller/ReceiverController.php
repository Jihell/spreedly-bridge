<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Jihel\OmnipaySpreedlyBridgeBundle\Entity\Receiver;
use Jihel\OmnipaySpreedlyBridgeBundle\Form\ReceiverRequestForm;
use Jihel\OmnipaySpreedlyBridgeBundle\Manager\ReceiverManager;
use Jihel\OmnipaySpreedlyBridgeBundle\Repository\ReceiverRepository;
use Omnipay\SpreedlyBridge\Gateway;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReceiverController
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ReceiverController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        /** @var EntityManagerInterface $m */
        $m = $this->getDoctrine()->getManager();
        /** @var ReceiverRepository $receiverRepository */
        $receiverRepository = $m->getRepository(Receiver::class);

        $receivers = $receiverRepository->findAll();

        return $this->render('JihelOmnipaySpreedlyBridgeBundle:Receiver:index.html.twig', [
            'receivers' => $receivers,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Omnipay\SpreedlyBridge\Exception\CreateReceiverException
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(ReceiverRequestForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            /** @var ReceiverManager $receiverManager */
            $receiverManager = $this->get('jihel.omnipay.manager.receiver');
            $receiverManager->create($data);

            return $this->redirectToRoute('JihelOmnipaySpreedlyBridgeBundle_receiver_index');
        }

        return $this->render('JihelOmnipaySpreedlyBridgeBundle:Receiver:create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Receiver $receiver
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function showAction(Receiver $receiver)
    {
        /** @var ReceiverManager $receiverManager */
        $receiverManager = $this->get('jihel.omnipay.bridge.receiver');
        $receiverManager->synchronise($receiver);

        return $this->render('JihelOmnipaySpreedlyBridgeBundle:Receiver:show.html.twig', [
            'receiver' => $receiver,
        ]);
    }
}
