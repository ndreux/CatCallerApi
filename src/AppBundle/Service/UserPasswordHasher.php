<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

/**
 * Class UserPasswordHasher
 */
class UserPasswordHasher
{
    /**
     * @var EncoderFactory
     */
    private $encoderFactory;

    /**
     * UserPasswordHasher constructor.
     *
     * @param EncoderFactory $encoderFactory
     */
    public function __construct(EncoderFactory $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * Reset user password and send him an email
     *
     * @param User $user
     */
    public function hashPassword(User $user)
    {
        $passwordEncoder = $this->encoderFactory->getEncoder($user);
        $encodedPassword = $passwordEncoder->encodePassword($user->getPlainPassword(), $user->getSalt());

        $user->setPassword($encodedPassword);
    }
}
