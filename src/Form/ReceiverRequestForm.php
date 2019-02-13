<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Form;

use Jihel\OmnipaySpreedlyBridgeBundle\Model\ReceiverRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ReceiverRequestForm
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ReceiverRequestForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', Type\ChoiceType::class, [
                'choices' => ['test', 'prod'],
                'choice_label' => function ($var) {
                    return sprintf('receiver.type.%s', $var);
                }
            ])
            ->add('hostnames', Type\TextType::class)
            ->add('credentials', Type\CollectionType::class, [
                'entry_type' => CredentialForm::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('bridgeClass', Type\TextType::class)
            ->add('receiverUser', Type\TextType::class)
            ->add('receiverPass', Type\TextType::class)
            ->add('receiverMid', Type\TextType::class)
            ->add('submit', Type\SubmitType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReceiverRequest::class,
            'cascade_validation' => true,
        ]);
    }
}
