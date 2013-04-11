<?php
namespace Witte\Kanban\Tests\Functional\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 * Copyright (C) 2012 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

use \Witte\Kanban\Domain\Model\Board;
use \Witte\Kanban\Domain\Model\Column;
use \Witte\Kanban\Domain\Model\Ticket;
/**
 * Testcase for Board
 */
class TicketTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * We need to enable this, so that the database is set up. Otherwise
	 * there will be an error along the lines of:
	 *  "Table 'functional_tests.domain' doesn't exist"
	 *
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = FALSE;

	/**
	 * @test
	 */
	public function addRemoveColumn(){
		$resource = new \TYPO3\Flow\Resource\Resource();
		$ticket = new Ticket();
		$ticket->setOriginalResource($resource);

		$this->assertEquals($resource, $ticket->getOriginalResource());
	}

}

?>