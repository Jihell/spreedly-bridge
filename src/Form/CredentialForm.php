<?php
/**
 * @licence Proprietary
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Form;

use Jihel\OmnipaySpreedlyBridgeBundle\Model\Credential;
use Jihel\OmnipaySpreedlyBridgeBundle\Model\ReceiverRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CredentialForm
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class CredentialForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', Type\TextType::class)
            ->add('value', Type\TextType::class)
            ->add('safe', Type\ChoiceType::class, [
                'choices' => [1, 0],
                'choice_label' => function ($var) {
                    return sprintf('credential.safe.%s', $var);
                }
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Credential::class,
            'cascade_validation' => true,
        ]);
    }
}
