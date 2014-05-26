<?php

namespace Roave\DeveloperTools;

use Roave\DeveloperTools\Inspector\ComposerInspector;
use Roave\DeveloperTools\Inspector\CounterInspector;
use Roave\DeveloperTools\Inspector\DeclaredSymbolsInspector;
use Roave\DeveloperTools\Inspector\IncludedFilesInspector;
use Roave\DeveloperTools\Inspector\InspectorInterface;
use Roave\DeveloperTools\Inspector\SharedEventManagerInspector;
use Roave\DeveloperTools\Inspector\TimeInspector;
use Roave\DeveloperTools\Mvc\Configuration\RoaveDeveloperToolsConfiguration;
use Roave\DeveloperTools\Mvc\Controller\InspectionController;
use Roave\DeveloperTools\Mvc\Controller\ListInspectionsController;
use Roave\DeveloperTools\Mvc\Factory\ApplicationInspectionRepositoryFactory;
use Roave\DeveloperTools\Mvc\Factory\ApplicationInspectorFactory;
use Roave\DeveloperTools\Mvc\Factory\ApplicationInspectorListenerFactory;
use Roave\DeveloperTools\Mvc\Factory\DetailInspectionRendererFactory;
use Roave\DeveloperTools\Mvc\Factory\InspectionControllerFactory;
use Roave\DeveloperTools\Mvc\Factory\ListInspectionsControllerFactory;
use Roave\DeveloperTools\Mvc\Factory\MergedConfigInspectorFactory;
use Roave\DeveloperTools\Mvc\Factory\RoaveDeveloperToolsConfigurationFactory;
use Roave\DeveloperTools\Mvc\Factory\SharedEventManagerInspectorFactory;
use Roave\DeveloperTools\Mvc\Factory\ToolbarInjectorListenerFactory;
use Roave\DeveloperTools\Mvc\Factory\ToolbarInspectionRendererFactory;
use Roave\DeveloperTools\Mvc\Inspector\ExceptionInspector;
use Roave\DeveloperTools\Mvc\Inspector\RequestInspector;
use Roave\DeveloperTools\Mvc\Inspector\ResponseInspector;
use Roave\DeveloperTools\Mvc\Listener\ApplicationInspectorListener;
use Roave\DeveloperTools\Mvc\Listener\ToolbarInjectorListener;
use Roave\DeveloperTools\Renderer\Detail\DetailEventsRenderer;
use Roave\DeveloperTools\Renderer\DetailInspectionRenderer;
use Roave\DeveloperTools\Renderer\ListInspectionRenderer;
use Roave\DeveloperTools\Renderer\ToolbarInspectionRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarComposerRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarConfigRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarCounterRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarDeclaredSymbolsRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarEventsRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarExceptionRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarIncludedFilesRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarRequestRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarResponseRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarTimeRenderer;
use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Roave\DeveloperTools\Repository\UUIDGenerator\SimplifiedUUIDGenerator;
use Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface;
use Zend\Mvc\Router\Http\Literal;
use Zend\Mvc\Router\Http\Segment;

$inspectionsDir =  'data/roave_developer_tools';

if(!is_dir($inspectionsDir)) {
    try {
        @mkdir($inspectionsDir, 0777, true);
    }
    catch (Exception $e){
        echo $e;
    }
}


return [
    'service_manager' => [
        'invokables' => [
            UUIDGeneratorInterface::class         => SimplifiedUUIDGenerator::class,
            ExceptionInspector::class             => ExceptionInspector::class,
            ToolbarExceptionRenderer::class       => ToolbarExceptionRenderer::class,
            ToolbarTimeRenderer::class            => ToolbarTimeRenderer::class,
            TimeInspector::class                  => TimeInspector::class,
            ToolbarEventsRenderer::class          => ToolbarEventsRenderer::class,
            ToolbarConfigRenderer::class          => ToolbarConfigRenderer::class,
            ToolbarRequestRenderer::class         => ToolbarRequestRenderer::class,
            ToolbarResponseRenderer::class        => ToolbarResponseRenderer::class,
            RequestInspector::class               => RequestInspector::class,
            ResponseInspector::class              => ResponseInspector::class,
            ListInspectionRenderer::class         => ListInspectionRenderer::class,
            DeclaredSymbolsInspector::class       => DeclaredSymbolsInspector::class,
            IncludedFilesInspector::class         => IncludedFilesInspector::class,
            ComposerInspector::class              => ComposerInspector::class,
            CounterInspector::class               => CounterInspector::class,
            ToolbarDeclaredSymbolsRenderer::class => ToolbarDeclaredSymbolsRenderer::class,
            ToolbarIncludedFilesRenderer::class   => ToolbarIncludedFilesRenderer::class,
            ToolbarComposerRenderer::class        => ToolbarComposerRenderer::class,
            DetailEventsRenderer::class           => DetailEventsRenderer::class,
            ToolbarCounterRenderer::class         => ToolbarCounterRenderer::class,
        ],
        'factories' => [
            ApplicationInspectorListener::class     => ApplicationInspectorListenerFactory::class,
            InspectorInterface::class               => ApplicationInspectorFactory::class,
            InspectionRepositoryInterface::class    => ApplicationInspectionRepositoryFactory::class,
            ToolbarInjectorListener::class          => ToolbarInjectorListenerFactory::class,
            RoaveDeveloperToolsConfiguration::class => RoaveDeveloperToolsConfigurationFactory::class,
            ToolbarInspectionRenderer::class        => ToolbarInspectionRendererFactory::class,
            SharedEventManagerInspector::class      => SharedEventManagerInspectorFactory::class,
            DetailInspectionRenderer::class         => DetailInspectionRendererFactory::class,

            'Roave\\DeveloperTools\\Mvc\\Inspector\\MergedConfigInspector' => MergedConfigInspectorFactory::class,
        ],
    ],

    'controllers' => [
        'factories' => [
            ListInspectionsController::class => ListInspectionsControllerFactory::class,
            InspectionController::class      => InspectionControllerFactory::class,
        ],
    ],

    'router' => [
        'routes' => [
            'roave-developer-tools' => [
                'type'          => Literal::class,
                'options'       => ['route' => '/roave-developer-tools'],
                'may_terminate' => false,
                'child_routes'  => [
                    'inspections' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/inspections',
                            'defaults' => ['controller' => ListInspectionsController::class],
                        ],
                        'may_terminate' => true,
                        'child_routes'  => [
                            'inspection' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'       => '/:inspectionId',
                                    'constraints' => [InspectionController::INSPECTION_ID => '.+'],
                                    'defaults'    => ['controller' => InspectionController::class],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'roave_developer_tools' => [
        // Directory where inspections should be saved
        'inspections_persistence_dir' => $inspectionsDir,
        // List of inspectors to be invoked when the `Zend\Mvc\MvcEvent::EVENT_FINISH` is fired
        'inspectors'                  => [
            'Roave\\DeveloperTools\\Mvc\\Inspector\\MergedConfigInspector',
            TimeInspector::class,
            ExceptionInspector::class,
            SharedEventManagerInspector::class,
            RequestInspector::class,
            ResponseInspector::class,
            DeclaredSymbolsInspector::class,
            IncludedFilesInspector::class,
            ComposerInspector::class,
            CounterInspector::class,
        ],
        // List of renderers to be invoked when trying to render toolbar segments
        'toolbar_tab_renderers'       => [
            ToolbarExceptionRenderer::class,
            ToolbarTimeRenderer::class,
            ToolbarEventsRenderer::class,
            ToolbarConfigRenderer::class,
            ToolbarRequestRenderer::class,
            ToolbarResponseRenderer::class,
            ToolbarDeclaredSymbolsRenderer::class,
            ToolbarIncludedFilesRenderer::class,
            ToolbarComposerRenderer::class,
            ToolbarCounterRenderer::class,
        ],
        // List of renderers to be invoked when trying to render the detail view
        'detail_renderers'       => [
            DetailEventsRenderer::class,
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            realpath(__DIR__ . '/../view'),
        ],
    ],
];
