<?php
/**
 * Created by PhpStorm.
 * User: Valery.Kuzmenka
 * Date: 5/11/2016
 * Time: 1:24 PM
 */

namespace Yoda\EventBundle\Reporting;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class EventReportManager
{
    private $em;
    private $router;

    public function __construct(EntityManager $em, Router $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public function getRecentlyUpdatedReport(){
        $events = $this->em->getRepository('YodaEventBundle:Event')
            ->getRecentlyUpdatedEvents();

        $rows = array();

        foreach($events as $event){
            $data = array(
                $event->getId(),
                $event->getName(),
                $event->getTime()->format('Y-m-d H:i:s'),
                $this->router->generate('event_show',
                    array('slug' => $event->getSlug()),
                    true // absolute urls
                    )
            );

            $rows[] = implode(', ' , $data);
        }

        $content = implode('\n', $rows);

        return $content;
    }
}