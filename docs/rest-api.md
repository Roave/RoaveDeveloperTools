# REST API

When using **RoaveDeveloperTools** in the context of a ZendFramework application,
it exposes a REST API that can be queried to view data about the various recorded
inspections.

The API currently only serves `application/json` data, and is read-only.

The URIs to access the API when **RoaveDeveloperTools** is enabled are:

 - `http://example.com/your/application/roave-developer-tools/inspections`
 - `http://example.com/your/application/roave-developer-tools/inspections/:inspectionId`

Where `http://example.com/your/application` is where your application's public
directory is located.

The structure of the data in the API is still not well defined, and is likely
going to change.

**Please note that this API exposes information about your application internals,
as well as configuration and confidential information. Do not expose RoaveDeveloperTools
in a production environment**
