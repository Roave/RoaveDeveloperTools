# ZendFramework Module wiring

RoaveDeveloperTools is shipped as a valid ZendFramework module. You can just enable it by loading
the module in your application's config by adding `Roave\DeveloperTools` to the configured modules.
 provides some base wiring for the interfaces described above:

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