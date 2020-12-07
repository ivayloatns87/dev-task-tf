<?php


namespace App\Controller;


use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractApiController extends AbstractFOSRestController
{
    /**
     * @param string $type
     * @param null $data
     * @param array $options
     * @return mixed
     */
    protected function buildForm(string $type, $data = null, array $options = []): FormInterface
    {
        $options = array_merge($options,[
            'csrf_protection' => false
        ]);

        return $this->container->get('form.factory')->createNamed('', $type, $data, $options);
    }

    /**
     * @param $data
     * @param int $statusCode
     * @return Response
     */
    protected function respond($data, int $statusCode = Response::HTTP_OK): Response
    {
        return $this->handleView($this->view($data, $statusCode));
    }
}