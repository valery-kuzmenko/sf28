<?php
/**
 * Created by PhpStorm.
 * User: Valery.Kuzmenka
 * Date: 5/11/2016
 * Time: 6:10 PM
 */

namespace Yoda\EventBundle\Twig;


use Yoda\EventBundle\Util\DateUtil;

class EventExtension extends \Twig_Extension
{
    public function getName(){
        return 'event';
    }

    public function getFilters(){
        return array(
            new \Twig_SimpleFilter('ago', array($this, 'calculateAgo'))
        );
    }

    public function calculateAgo(\DateTime $data){
        return DateUtil::ago($data);
    }
}