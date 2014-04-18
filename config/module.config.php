<?php

namespace Roave\DeveloperTools;

use Roave\DeveloperTools\Inspector\InspectorInterface;
use Roave\DeveloperTools\Mvc\Factory\ApplicationInspectionRepositoryFactory;
use Roave\DeveloperTools\Mvc\Factory\ApplicationInspectorFactory;
use Roave\DeveloperTools\Mvc\Factory\ApplicationInspectorListenerFactory;
use Roave\DeveloperTools\Mvc\Factory\ToolbarInjectorListenerFactory;
use Roave\DeveloperTools\Mvc\Listener\ApplicationInspectorListener;
use Roave\DeveloperTools\Mvc\Listener\ToolbarInjectorListener;
use Roave\DeveloperTools\Renderer\InspectionRendererInterface;
use Roave\DeveloperTools\Renderer\ToolbarInspectionRenderer;
use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Roave\DeveloperTools\Repository\UUIDGenerator\SimplifiedUUIDGenerator;
use Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface;

$tmpDir = sys_get_temp_dir() . '/roave_developer_tools';

@mkdir($tmpDir);

return [
    'service_manager' => [
        'invokables' => [
            UUIDGeneratorInterface::class                    => SimplifiedUUIDGenerator::class,
            InspectionRendererInterface::class . '\\Toolbar' => ToolbarInspectionRenderer::class,
        ],
        'factories' => [
            ApplicationInspectorListener::class  => ApplicationInspectorListenerFactory::class,
            InspectorInterface::class            => ApplicationInspectorFactory::class,
            InspectionRepositoryInterface::class => ApplicationInspectionRepositoryFactory::class,
            ToolbarInjectorListener::class       => ToolbarInjectorListenerFactory::class,
        ],
    ],

    'roave_developer_tools' => [
        'inspections_persistence_dir' => $tmpDir,
    ],
];
