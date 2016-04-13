<?php

namespace Yoda\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($count, $firstName)
    {
        // these 2 lines are equivalent
        // $em = $this->container->get('doctrine')->getManager();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('YodaEventBundle:Event');

        $event = $repo->findOneBy(array(
            'name' => 'party',
        ));

        return $this->render(
            'YodaEventBundle:Default:index.html.twig',
            array(
                'name' => $firstName,
                'count' => $count,
                'event'=> $event,
            )
        );
    }
}