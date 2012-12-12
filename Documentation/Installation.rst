Witte:Kanban
============

This a simple project to learn something about TYPO3 Flow so you'll need TYPO3 Flow to run this application.

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
      uriPattern: 'witte.kanban<KanbanSubroutes>'
      subRoutes:
        KanbanSubroutes:
          package: Witte.Kanban


Call the application in the browser by http://your-host/witte.kanban