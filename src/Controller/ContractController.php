<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\ContractLease;
use App\Entity\ContractOwnership;
use App\Form\ContractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ContractController extends AbstractApiController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function contractsAction(Request $request): Response
    {
        $contracts = $this->getDoctrine()->getRepository(Contract::class)->findAll();

        return $this->respond($contracts, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $form = $this->buildForm( ContractType::class);


        $form->handleRequest($request);


        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Contract $contract */
        $contract = $form->getData();
        $estates = $form->get('estates')->getData();

        foreach ($estates as $estate) {
            $contract->addEstate($estate);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($contract);
        $em->flush();

        return $this->respond($contract->getId(), Response::HTTP_CREATED);
    }

    public function dueRentAction(Request $request): Response
    {
        $contracts = $this->getDoctrine()->getRepository(ContractLease::class)->getDueRent();

        return $this->respond($contracts, Response::HTTP_OK);
    }

    public function getUserEstates(Request $request): Response
    {
        $contracts = $this->getDoctrine()->getRepository(ContractOwnership::class)->getUserEstates();

        return $this->respond($contracts, Response::HTTP_OK);
    }
}
