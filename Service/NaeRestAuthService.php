<?php

namespace NaeSymfonyBundles\NaeRestBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use NaeSymfonyBundles\NaeAuthBundle\Auth\NaeUser;

class NaeRestAuthService
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    protected $entityManager;

    /**
     * NaeRestAuthService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param NaeUser $naeUser
     * @return object
     * @throws Exception
     */
    public function decodeUser(NaeUser $naeUser)
    {
        $userRepo = $this->entityManager->getRepository('App\Entity\User');
        $user = $userRepo->find($naeUser->getId());
        if (!$user) {
            throw new Exception('User decode error');
        }
        return $user;
    }
}