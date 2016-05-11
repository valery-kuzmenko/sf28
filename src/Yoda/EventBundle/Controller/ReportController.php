<?php
/**
 * Created by PhpStorm.
 * User: Valery.Kuzmenka
 * Date: 5/11/2016
 * Time: 12:49 PM
 */

namespace Yoda\EventBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Yoda\EventBundle\Reporting\EventReportManager;

class ReportController extends Controller
{
    /**
     * @Route("/events/report/recentlyUpdated.csv")
     */
    public function updatedEventsAction(){

        $eventReportManager = $this->container->get('event_report_manager');

        //$eventReportManager = new EventReportManager($this->getDoctrine()->getManager());
        $content = $eventReportManager->getRecentlyUpdatedReport();

        $response = new Response($content);
        $response->headers->set('Content-type', 'text/csv');

        return $response;
    }

}