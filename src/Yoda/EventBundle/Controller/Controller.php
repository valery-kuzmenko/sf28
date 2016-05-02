<?php
/**
 * Created by PhpStorm.
 * User: Valery.Kuzmenka
 * Date: 5/2/2016
 * Time: 1:41 PM
 */

namespace Yoda\EventBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;


class Controller extends BaseController
{
    /**
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    public function getSecurityContext()
    {
        return $this->container->get('security.context');
    }

    public function enforceUserSecuriety()
    {
        if (!$this->getSecurityContext()->isGranted('ROLE_USER')) {
            throw new AccessDeniedException('Need role user');
        }
    }

    public function enforceOwnerSecurity(Event $event)
    {
        $user = $this->getUser();
        if($event->getOwner() != $user){
            throw new AccessDeniedException('You dont own this');
        }
    }
}