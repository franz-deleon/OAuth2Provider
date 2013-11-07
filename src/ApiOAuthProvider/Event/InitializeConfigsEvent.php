<?php
namespace ApiOAuthProvider\Event;

use Zend\EventManager\Event;

class InitializeConfigsEvent extends Event
{
    const PRE_INITIALIZE  = 'pre.InitializeConfigsEvent';
}
