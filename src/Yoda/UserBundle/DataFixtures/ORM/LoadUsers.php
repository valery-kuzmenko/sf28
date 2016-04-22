<?php

namespace Yoda\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Yoda\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setPassword($this->encodePassword($user, 'user'));
        $user->setEmail('user@ya.ru');
        $manager->persist($user);

        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->encodePassword($user, 'admin'));
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setIsActive(true);
        $user->setEmail('admin@ya.ru');
        $manager->persist($user);

        // the queries aren't done until now
        $manager->flush();
    }

    private function encodePassword(User $user, $plainPassword){
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    /**
     * This metod id required by ContainerAwareInterface
     * it will be called during construction
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
