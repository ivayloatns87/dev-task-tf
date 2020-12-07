<?php

namespace App\Controller;

use App\Entity\LandOwner;
use App\Form\LandOwnerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LandOwnerController extends AbstractApiController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $form = $this->buildForm(LandOwnerType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var LandOwner $lessor */
        $lessor = $form->getData();

        $em = $this->getDoctrine()->getManager();
        $em->persist($lessor);
        $em->flush();

        return $this->respond($lessor, Response::HTTP_CREATED);
    }
}
