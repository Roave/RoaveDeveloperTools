<?php

namespace Roave\DeveloperTools;

use Roave\DeveloperTools\Inspector\InspectorInterface;
use Roave\DeveloperTools\Inspector\SharedEventManagerInspector;
use Roave\DeveloperTools\Inspector\TimeInspector;
use Roave\DeveloperTools\Mvc\Configuration\RoaveDeveloperToolsConfiguration;
use Roave\DeveloperTools\Mvc\Factory\ApplicationInspectionRepositoryFactory;
use Roave\DeveloperTools\Mvc\Factory\ApplicationInspectorFactory;
use Roave\DeveloperTools\Mvc\Factory\ApplicationInspectorListenerFactory;
use Roave\DeveloperTools\Mvc\Factory\MergedConfigInspectorFactory;
use Roave\DeveloperTools\Mvc\Factory\RoaveDeveloperToolsConfigurationFactory;
use Roave\DeveloperTools\Mvc\Factory\SharedEventManagerInspectorFactory;
use Roave\DeveloperTools\Mvc\Factory\ToolbarInjectorListenerFactory;
use Roave\DeveloperTools\Mvc\Factory\ToolbarInspectionRendererFactory;
use Roave\DeveloperTools\Mvc\Inspector\ExceptionInspector;
use Roave\DeveloperTools\Mvc\Listener\ApplicationInspectorListener;
use Roave\DeveloperTools\Mvc\Listener\ToolbarInjectorListener;
use Roave\DeveloperTools\Renderer\ToolbarInspectionRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarConfigRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarEventsRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarExceptionRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarTimeRenderer;
use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Roave\DeveloperTools\Repository\UUIDGenerator\SimplifiedUUIDGenerator;
use Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface;

$inspectionsDir =  'data/roave_developer_tools';

@mkdir($inspectionsDir, 0777, true);

return [
    'service_manager' => [
        'invokables' => [
            UUIDGeneratorInterface::class   => SimplifiedUUIDGenerator::class,
            ExceptionInspector::class       => ExceptionInspector::class,
            ToolbarExceptionRenderer::class => ToolbarExceptionRenderer::class,
            ToolbarTimeRenderer::class      => ToolbarTimeRenderer::class,
            TimeInspector::class            => TimeInspector::class,
            ToolbarEventsRenderer::class    => ToolbarEventsRenderer::class,
            ToolbarConfigRenderer::class    => ToolbarConfigRenderer::class,
        ],
        'factories' => [
            ApplicationInspectorListener::class     => ApplicationInspectorListenerFactory::class,
            InspectorInterface::class               => ApplicationInspectorFactory::class,
            InspectionRepositoryInterface::class    => ApplicationInspectionRepositoryFactory::class,
            ToolbarInjectorListener::class          => ToolbarInjectorListenerFactory::class,
            RoaveDeveloperToolsConfiguration::class => RoaveDeveloperToolsConfigurationFactory::class,
            ToolbarInspectionRenderer::class        => ToolbarInspectionRendererFactory::class,
            SharedEventManagerInspector::class      => SharedEventManagerInspectorFactory::class,

            'Roave\\DeveloperTools\\Mvc\\Inspector\\MergedConfigInspector' => MergedConfigInspectorFactory::class,
        ],
    ],

    'roave_developer_tools' => [
        'inspections_persistence_dir' => $inspectionsDir,
        'inspectors'                  => [
            'Roave\\DeveloperTools\\Mvc\\Inspector\\MergedConfigInspector',
            TimeInspector::class,
            ExceptionInspector::class,
            SharedEventManagerInspector::class,
        ],
        'toolbar_tab_renderers'       => [
            ToolbarExceptionRenderer::class,
            ToolbarTimeRenderer::class,
            ToolbarEventsRenderer::class,
            ToolbarConfigRenderer::class,
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            realpath(__DIR__ . '/../view'),
        ],
    ],
];
