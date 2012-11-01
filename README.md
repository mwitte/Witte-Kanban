Witte.Kanban
============

This a simple private project to learn something about TYPO3 Flow.

Installation
------------

Copy the package to the folder "<FlowInstance>/Packages/Application" of your TYPO3 Flow instance.


### Activate the package:

    ./flow package:activate Witte.Kanban


### Migrate the database:

    ./flow doctrine:migrate


### Add Route

Add a route to the Routes.yaml of your TYPO3 Flow instance("<FlowInstance>/Configuration/Routes.yaml") with
the following content:

    -
      name: 'Kanban'
      uriPattern: '<KanbanSubroutes>'
      subRoutes:
        KanbanSubroutes:
          package: Witte.Kanban


Call the application in the browser by http://your-host/witte.kanban

Licence
-------
This work is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.

### Author

Matthias Witte
http://www.matthias-witte.net/

### Twitter Bootstrap

This project uses Twitter Bootstrap as CSS and JavaScript framework.
Code licensed under Apache License v2.0, documentation under CC BY 3.0.
Glyphicons Free licensed under CC BY 3.0.

http://twitter.github.com/bootstrap/