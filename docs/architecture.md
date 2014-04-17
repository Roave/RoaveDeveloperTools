# Architecture Overview

This file includes a broad view of the architecture of RoaveDeveloperTools


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
`Roave\DeveloperTools\Renderer\InspectionRendererInterface` may report wheter it supports rendering
a provided `Roave\DeveloperTools\Renderer\InspectionRendererInterface`

