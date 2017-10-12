<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use AppBundle\Service\UserPasswordHasher;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class CreateUser
 */
class CreateUserListener
{
    /**
     * @var UserPasswordHasher
     */
    private $userPasswordHasher;

    /**
     * UserPasswordGenerationAction constructor.
     *
     * @param $userPasswordHasher
     */
    public function __construct(UserPasswordHasher $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if (!$entity instanceof User || $entity->getPassword() !== null) {
            return;
        }

        $this->userPasswordHasher->hashPassword($entity);
    }
}
