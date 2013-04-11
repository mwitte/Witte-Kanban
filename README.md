Witte:Kanban
============

This a simple project to learn something about TYPO3 Flow so you'll need TYPO3 Flow to run this application. More
information about this project can be found in my
[blog post](http://www.matthias-witte.net/wittekanban-a-typo3-flow-application/2012/12/).

Installation
------------

Copy the package to the folder "<FlowInstance>/Packages/Application" of your TYPO3 Flow instance and name it

	Witte.Kanban


### Activate the package:

	./flow package:activate Witte.Kanban


### Migrate the database:

	./flow doctrine:migrate


### Add Route

Add a route as first rule to the Routes.yaml of your TYPO3 Flow instance("<FlowInstance>/Configuration/Routes.yaml") with
the following content:

	-
	  name: 'Kanban'
	  uriPattern: 'kanban<KanbanSubroutes>'
	  subRoutes:
	    KanbanSubroutes:
	      package: Witte.Kanban


Call the application in the browser by http://your-host/kanban

Licence
-------
Witte:Kanban is a simple TYPO3 Flow Application which provides Kanban boards with multiple columns and tickets.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Copyright (C) 2012 Matthias Witte http://www.matthias-witte.net/

### Twitter Bootstrap

This project uses Twitter Bootstrap as CSS and JavaScript framework.
Code licensed under Apache License v2.0, documentation under CC BY 3.0.
Glyphicons Free licensed under CC BY 3.0.

http://twitter.github.com/bootstrap/