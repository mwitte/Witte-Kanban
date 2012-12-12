<?php
namespace Witte\Kanban\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 * Copyright (C) 2012 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

use TYPO3\Flow\Annotations as Flow;

use TYPO3\Flow\Mvc\Controller\ActionController;
use \Witte\Kanban\Domain\Model\Board;
use \Witte\Kanban\Domain\Model\SuperiorColumn;

/**
 * Base controller for the Witte.Kanban package
 *
 * @Flow\Scope("singleton")
 */
class BaseController extends AbstractController {

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->addNeededObjectsToView();
	}

	/**
	 * @return void
	 */
	public function aboutAction() {
		$this->addNeededObjectsToView();
	}
}

?>