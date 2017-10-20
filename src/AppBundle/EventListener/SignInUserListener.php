<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;


/**
 * Class SignInUserListener
 */
class SignInUserListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * SignInUserListener constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $user->setLastConnectedAt(new DateTime());
        $this->entityManager->flush($user);
    }
}
