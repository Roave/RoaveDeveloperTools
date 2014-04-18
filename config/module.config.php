<?php

namespace Roave\DeveloperTools;

use Roave\DeveloperTools\Mvc\Factory\ApplicationInspectorListenerFactory;
use Roave\DeveloperTools\Mvc\Listener\ApplicationInspectorListener;

return [
    'service_manager' => [
        'factories' => [
            ApplicationInspectorListener::class => ApplicationInspectorListenerFactory::class,
        ],
    ],
];
