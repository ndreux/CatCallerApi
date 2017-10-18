<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use AppBundle\Service\UserPasswordHasher;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Class CreateUser
 */
class UpdateUserListener
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

    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getEntity();

        if (!$entity instanceof User || $entity->getPlainPassword() === null) {
            return;
        }

//        $this->userPasswordHasher->hashPassword($entity);
    }
}
