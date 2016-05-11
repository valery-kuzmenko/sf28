<?php
/**
 * Created by PhpStorm.
 * User: Valery.Kuzmenka
 * Date: 5/11/2016
 * Time: 6:37 PM
 */

namespace Yoda\EventBundle\Doctrine;

use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Yoda\UserBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UserListener
{
    private $encoderFactory;

    public function __construct(EncoderFactory $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof User){
            $this->handleEvent($entity);
        }
    }

    private function handleEvent(User $user)
    {
        $plainPassword = $user->getPlainPassword();
        $encoder = $this->encoderFactory
            ->getEncoder($user);

        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
    }
}