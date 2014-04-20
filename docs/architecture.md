# Architecture Overview

This file includes a broad view of the architecture of RoaveDeveloperTools

## Main Interface purposes

The interfaces of RoaveDeveloperTools are designed to profile and inspect relevant application events
in a generic PHP application. Such events may include customer-specific events (checkouts/business
relevant processes) or generic technical domain events (errors, dispatch events, MVC components used
in an application's run).

RoaveDeveloperTools is designed as a reusable generic profiling/introspection library, so it should
be usable in any PHP application that needs profiling.

### Inspection Results

RoaveDeveloperTools is based on the concept of `Roave\DeveloperTools\Inspection\InspectionInterface`,
which is a serializable data-packet that is usually created during any of the various workflows of a
"inspected/monitored" application.

### Inspectors

Inspectors are simple services implementing the `Roave\DeveloperTools\Inspector\InspectorInterface`.
An inspector is a service that may be asked to produce a
`Roave\DeveloperTools\Inspection\InspectionInterface` at any point in time given an event.

### Repositories

Inspections can be stored/fetched via a `Roave\DeveloperTools\Repository\InspectionRepositoryInterface`
instance.

### Inspection Result Renderers

Inspection results can be rendered via a `Roave\DeveloperTools\Renderer\InspectionRendererInterface`,
which converts a given instance of an `Roave\DeveloperTools\Inspection\InspectionInterface`
into a `Zend\View\Model\ModelInterface` or a `Zend\Stdlib\ResponseInterface`. Also, an
`Roave\DeveloperTools\Renderer\InspectionRendererInterface` may report whether it supports rendering
a provided `Roave\DeveloperTools\Renderer\InspectionRendererInterface` or not
