<?php
/**
 * Created by PhpStorm.
 * User: ndreux
 * Date: 23/11/2017
 * Time: 14:19
 */

namespace AppBundle\EventListener;


use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class AuthenticateUserListener
{

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload        = $event->getData();
        $payload['uid'] = $this->tokenStorage->getToken()->getUser()->getId();

        $event->setData($payload);
    }

}