<?php


namespace App\Form;


use App\Entity\Contract;
use App\Entity\LandOwner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class LandOwnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'LandOwnerRepository first name can not be null'
                    ]),
                ]
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'LandOwnerRepository last name can not be null'
                    ]),
                ]
            ])
            ->add('phone', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Phone can not be empty'
                    ]),
                ]
            ])
            ->add('personalIdentificationNumber',  TextType::class,[
                'constraints' => [
                    new NotNull([
                        'message' => 'Id can not be null'
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => LandOwner::class,
            'allow_extra_fields' => true,
            'empty_data' => function(FormInterface $form) {
                $firstName = $form->get('firstName')->getData();
                $lastName = $form->get('lastName')->getData();
                $phone = $form->get('lastName')->getData();
                $id = $form->get('personalIdentificationNumber')->getData();

                if (!$firstName || !$lastName || !$phone || !$id) {
                    return null;
                }

                return new LandOwner($firstName, $lastName, $phone, $id);
            }
        ]);
    }
}