<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\Estate;
use App\Form\EstateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EstateController extends AbstractApiController
{

    /**
     * @param Request $request
     * @return Response
     */
    public function estateAction(Request $request): Response
    {
        $contractId = $request->get('id');

        $contract = $this->getDoctrine()->getRepository(Contract::class)->findOneBy([
            'id' => $contractId
        ]);

        if (!$contract) {
            throw new NotFoundHttpException("Contract not found");
        }


        $estate = $this->getDoctrine()->getRepository(Estate::class)->findOneBy([
            'contract' => $contractId,
        ]);

        if (!$estate) {
            throw new NotFoundHttpException('No Estate related to this contract');
        }

        return $this->json([

        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $form = $this->buildForm( EstateType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        $estate = $this->getDoctrine()->getRepository(Estate::class)->findOneBy([
            'estateNumber' => $form->get('estateNumber')->getData()
        ]);

        if ( $estate ) {
            throw new BadRequestHttpException("Estate number already exists.");
        }


        /** @var Estate $estate */
        $estate = $form->getData();

        $em = $this->getDoctrine()->getManager();
        $em->persist($estate);
        $em->flush();

        return $this->respond(['id'=> $estate->getId()], Response::HTTP_CREATED);
    }
}
