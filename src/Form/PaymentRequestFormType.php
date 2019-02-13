<?php
/**
 * @package front
 */
namespace Jihel\OmnipaySpreedlyBridgeBundle\Form;

use Jihel\OmnipaySpreedlyBridgeBundle\Model\PaymentRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PaymentRequestFormType
 *
 * @author Joseph LEMOINE <dev@aa-digital.net>
  */
class PaymentRequestFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', Type\TextType::class, [
                'label' => 'jihel.omnipay.payment_request.fullName',
                'attr' => [
                    'autocomplete' => 'cc-name',
                    'x-autocompletetype' => 'cc-full-name',
                    'data-code' => 4,
                ],
            ])
            ->add('month', Type\ChoiceType::class, [
                'label' => 'jihel.omnipay.payment_request.month',
                'choices' => range(1, 12),
                'choice_label' => function ($val) {
                    return str_pad($val, 2, '0', STR_PAD_LEFT);
                },
                'choice_value' => function ($val) {
                    return str_pad($val, 2, '0', STR_PAD_LEFT);
                },
                'attr' => [
                    'class' => 'jihel_pyament_request__month',
                    'autocomplete' => 'cc-exp-month',
                    'x-autocompletetype' => 'cc-exp-month',
                    'data-code' => 16,
                ],
            ])
            ->add('year', Type\ChoiceType::class, [
                'label' => 'jihel.omnipay.payment_request.year',
                'choices' => range(date('Y'), date('Y') + 6),
                'choice_label' => function ($val) {
                    return $val;
                },
                'attr' => [
                    'class' => 'jihel_pyament_request__year',
                    'autocomplete' => 'cc-exp-year',
                    'x-autocompletetype' => 'cc-exp-year',
                    'data-code' => 32,
                ],
            ])
            ->add('token', Type\HiddenType::class, [
                'label' => 'jihel.omnipay.payment_request.token',
                'required' => false, // Handled by JS
                'attr' => [
                    'class' => 'jihel_pyament_request__token',
                ],
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PaymentRequest::class,
        ]);
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'omnipay_payment';
    }
}
