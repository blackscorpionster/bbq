<?php
declare(strict_types=1);

namespace src\bbq;
use src\config\Events;
use src\bbq\ActionHandler;
use src\bbq\DependencyHandler;
use src\bbq\SystemEvent;

class SystemEventHandler {

    private array $systemEvents;
    private ActionHandler $actionHandler;

    public function __construct(Events $events, ActionHandler $actionHandler) {
        $systemEvents = $events->getEvents();
        $this->actionHandler = $actionHandler;
        foreach($systemEvents as $systemEvent) {
            if (false === in_array($systemEvent->getEventName(), SystemEvent::SYSTEM_EVENTS)) {
                continue;
            }
            $this->systemEvents[] = $systemEvent;
        }
        $this->triggerEvents();
    }

    /**
     * Finds in the action handler, the request type and the http method and
     * looks up in the event listener any user defined Sytem even and then 
     * instatiates the class and runs the user specified method
     */
    private function triggerEvents(): void {
        if (empty($this->systemEvents)) {
            return;
        }

        // Check request type and http method for in the request and tries to find a match in the
        // user define system events
        $requestType = $this->actionHandler->getRoute()->getApiType();
        $httpMethod = $this->resolveActionMethod($this->actionHandler->getRoute()->getMethod());
        
        // triggers defined SYSTEM events for each type, in no particular order except the order
        // in which they were created in the Events class.
        // These events are supposed to do a preprocessing before the controller is called
        // therefore, these events should be used for generic authorization validations
        // csrf token checks. ActionHandler is available for theses events
        // This events do not return anything, but you can use the session to pass information
        // to the controller
        // EXCEPTIONS are always available
        // System Events METHODS must not expect arguments, ActionHandler has all the action's information
        // and it should be injected in the constructor of the event
        foreach($this->systemEvents as $systemEvent) {
            if (\in_array($systemEvent->getEventName(), [$requestType, $httpMethod])) {
                $this->invokeEventMethod($systemEvent);
            }
        }
    }

    private function invokeEventMethod(SystemEvent $systemEvent) {
        // Resolves the class' constructor parameters and instantiates the class
        $classHandler = new DependencyHandler($systemEvent->getClassPath(), $this->actionHandler);

        $classInstance = $classHandler->getClassInstance();

        $reflection = new \ReflectionMethod($classInstance, $systemEvent->getMethod());

        $pass = array();

        // Invokes event method
        $reflection->invokeArgs($classInstance, $pass);
    }

    private function resolveActionMethod(string $method) {
        return $method === SystemEvent::GET_REQUEST ? SystemEvent::GET_REQUEST : SystemEvent::POST_REQUEST;
    }
}
