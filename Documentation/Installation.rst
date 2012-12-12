How to install Witte.Kanban
---------------------------

Copy sources
************

Copy the Package to the folder "<FlowInstance>/Packages/Application" of your TYPO3 Flow instance.


Activate the package:
*********************

./flow package:activate Witte.Kanban


Migrate the database:
*********************

./flow doctrine:migrate


Add Route
*********

Add a route to the Routes.yaml of your TYPO3 Flow instance("<FlowInstance>/Configuration/Routes.yaml") with
the following content:

-
  name: 'Kanban'
  uriPattern: 'witte.kanban<KanbanSubroutes>'
  subRoutes:
    KanbanSubroutes:
      package: Witte.Kanban


Call the Kanban system in the browser by http://yourhost/witte.kanban