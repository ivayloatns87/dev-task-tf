<?php


namespace App\Form\Subscriber;


use App\Entity\Contract;
use App\Form\EstateType;
use App\Form\LandOwnerType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotNull;

class ContractTypeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => 'preSubmit',
            FormEvents::POST_SUBMIT => 'postSubmit'
        ];
    }

    public function preSubmit(FormEvent $event): void
    {
        $data = $event->getData();
        $form = $event->getForm();

        if ($data['type'] == Contract::CONTRACT_LEASE_TYPE) {
            $form
                ->add('contractEndDate', TextType::class,[
                    'constraints' => [
                        new NotNull(),
                    ]
                ])
                ->add('rentPerAcre', MoneyType::class,[
                    'constraints' => [
                        new NotNull(),
                        new GreaterThan([
                            'value' => 0
                        ])
                    ]
                ])
            ;
        } else {
            $form
                ->add('price', MoneyType::class,[
                    'constraints' => [
                        new NotNull(),
                        new GreaterThan([
                            'value' => 0
                        ])
                    ]
                ])
            ;
        }
    }

    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();

        if ($form->getErrors(true)->count()) {
            return;
        }
    }
}