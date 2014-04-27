# Using RoaveDeveloperTools in a ZendFramework Application

**RoaveDeveloperTools** ships as a module that can be enabled in a `Zend\Mvc\Application`. To use
it, simply enable module `Roave\DeveloperTools` in your `config/application.config.php` configuration
file.

Once the module is enabled, you should be able to see a toolbar similar to the following (may vary, as
the module is undergoing heavy development) at the bottom of your web-pages:

![toolbar preview](img/toolbar.png)

Also, you may browse to `http://your-app/path/roave-developer-tools/list-inspections` to have a list
of all the inspections that **RoaveDeveloperTools** recorded.

## ZendFramework Module wiring

The module provides some base wiring for the interfaces described in [architecture.md](architecture.md).

The module components are under the `Roave\DeveloperTools\Mvc` namespace. Components under this
namespace are specific about profiling a Zend Framework (2.x, currently) application.

 - an "inspector" configuration, containing the names of the services pointing at inspectors (a
   dedicated `InspectorPluginManager` will be provided)
 - a default inspection repository, implementing
   the `Roave\DeveloperTools\Repository\InspectionRepositoryInterface`
 - one or more main listeners that will fetch configured inspectors and cycle through all of them
   during the `Zend\Mvc\MvcEvent::EVENT_FINISH` event triggering, persisting each of the inspectors'
   results
 - generic HTML and JSON renderers for the inspections that are provided out of the box
 - a "toolbar" listener that will read the last persisted inspection and provide overview of the
   collected inspections using a set of configured
   `Roave\DeveloperTools\Renderer\InspectionRendererInterface` instances
 - a set of controllers to be used to analyze and render previous inspections

## Configuration

The current configuration is still work-in-progress and will be finalized once the complete output
PoC is done.
