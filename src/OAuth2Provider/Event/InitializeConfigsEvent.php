<?php
namespace OAuth2Provider\Event;

use Zend\EventManager\Event;

class InitializeConfigsEvent extends Event
{
    const PRE_INITIALIZE  = 'pre.InitializeConfigsEvent';
}
