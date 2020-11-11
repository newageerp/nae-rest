<?php

namespace NaeSymfonyBundles\NaeRestBundle\Controller;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NaeRestController
 * @package NaeSymfonyBundles\NaeRestBundle\Controller
 */
abstract class NaeRestController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ServiceEntityRepositoryInterface $repository
     * @return JsonResponse
     * @Route("/posts", name="posts_add", methods={"POST"})
     */
    abstract public function addElement(
        Request $request,
        EntityManagerInterface $entityManager,
        ServiceEntityRepositoryInterface $repository
    ): JsonResponse;


    /**
     * @param ServiceEntityRepositoryInterface $repository
     * @return JsonResponse
     * @Route("/", methods={"GET"})
     */
    abstract public function getElements(ServiceEntityRepositoryInterface $repository);


    /**
     * @param ServiceEntityRepositoryInterface $repository
     * @param $id
     * @return JsonResponse
     * @Route("/{id}", methods={"GET"})
     */
    abstract public function getElement(ServiceEntityRepositoryInterface $repository, string $id);

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ServiceEntityRepositoryInterface $repository
     * @param string $id
     * @return JsonResponse
     * @Route("/{id}", methods={"PUT"})
     */
    abstract public function updateElement(
        Request $request,
        EntityManagerInterface $entityManager,
        ServiceEntityRepositoryInterface $repository,
        string $id
    );

    /**
     * @param EntityManagerInterface $entityManager
     * @param ServiceEntityRepositoryInterface $repository
     * @param string $id
     * @return JsonResponse
     * @Route("/{id}", methods={"DELETE"})
     */
    abstract public function deleteElement(
        EntityManagerInterface $entityManager,
        ServiceEntityRepositoryInterface $repository,
        string $id
    );

    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    protected function response(array $data, int $status = 200, $headers = []): JsonResponse
    {
        return new JsonResponse($data, $status, $headers);
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function transformJsonBody(Request $request) : Request
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}