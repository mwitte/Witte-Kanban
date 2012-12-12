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
class BoardTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

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
		$board = new Board();
		$firstColumn = new Column();
		$secondColumn = new Column();

		$this->assertEquals(0, $board->getColumns()->count(), 'There should be no columns yet');

		$board->addColumn($firstColumn);
		$board->addColumn($secondColumn);

		$this->assertEquals(2, $board->getColumns()->count(), 'There should be 2 columns');
		$this->assertEquals($firstColumn, $board->getColumns()->first(), 'First column failed');
		$this->assertEquals($secondColumn, $board->getColumns()->last(), 'Second column failed');

		$board->removeColumn($firstColumn);

		$this->assertEquals(1, $board->getColumns()->count(), 'There should be only 1 column');

		$board->removeColumn($secondColumn);

		$this->assertEquals(0, $board->getColumns()->count(), 'There should be no columns after removing');
	}

	/**
	 * @test
	 */
	public function addRemoveTicketArchive(){
		$board = new Board();
		$firstTicket = new Ticket();
		$secondTicket = new Ticket();

		$this->assertEquals(0, $board->getTicketArchive()->count(), 'There should be no tickets yet');

		$board->addToTicketArchive($firstTicket);
		$board->addToTicketArchive($secondTicket);

		$this->assertEquals(2, $board->getTicketArchive()->count(), 'There should be 2 tickets');
		$this->assertEquals($firstTicket, $board->getTicketArchive()->first(), 'First ticket failed');
		$this->assertEquals($secondTicket, $board->getTicketArchive()->last(), 'Second ticket failed');

		$board->removeFromTicketArchive($firstTicket);

		$this->assertEquals(1, $board->getTicketArchive()->count(), 'There should be only 1 ticket');

		$board->removeFromTicketArchive($secondTicket);

		$this->assertEquals(0, $board->getTicketArchive()->count());
	}
}

?>