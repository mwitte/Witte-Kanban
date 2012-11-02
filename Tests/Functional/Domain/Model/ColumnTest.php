<?php
namespace Witte\Kanban\Tests\Functional\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */
use \Witte\Kanban\Domain\Model\Column;
use \Witte\Kanban\Domain\Model\Ticket;
use \Witte\Kanban\Domain\Model\Board;
/**
 * Testcase for Board
 */
class ColumnTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * We need to enable this, so that the database is set up. Otherwise
	 * there will be an error along the lines of:
	 *  "Table 'functional_tests.domain' doesn't exist"
	 *
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = FALSE;

	/**
	 * @var boolean
	 */
	protected $testableSecurityEnabled = FALSE;

	/**
	 * @var boolean
	 */
	protected $testableHttpEnabled = FALSE;

	/**
	 * @test
	 */
	public function addRemoveSubColumn(){
		$column = new Column();
		$firstSubColumn = new Column();
		$secondSubColumn = new Column();

		$this->assertEquals(0, $column->getSubColumns()->count(), 'There should be 0 subColumns yet');

		$column->addSubColumn($firstSubColumn);
		$column->addSubColumn($secondSubColumn);

		$this->assertEquals($firstSubColumn, $column->getSubColumns()->first(), 'First Column should be equal');
		$this->assertEquals($secondSubColumn, $column->getSubColumns()->last(), 'Second Column should be equal');
		$this->assertEquals(2, $column->getSubColumns()->count(), 'There should be 2 subColumns');

		$column->removeSubColumn($firstSubColumn);

		$this->assertEquals(1, $column->getSubColumns()->count(), 'There should be 1 subColumn');
		$this->assertEquals($secondSubColumn, $column->getSubColumns()->first(), 'The first subColumn should be the secondSubColumn');
	}

	/**
	 * @test
	 */
	public function addRemoveTicket(){
		$column = new Column();
		$firstTicket = new Ticket();
		$secondTicket = new Ticket();

		$this->assertEquals(0, $column->getTickets()->count(), 'There should be 0 tickets yet');

		$column->addTicket($firstTicket);
		$column->addTicket($secondTicket);

		$this->assertEquals($firstTicket, $column->getTickets()->first(), 'First Ticket should be equal');
		$this->assertEquals($secondTicket, $column->getTickets()->last(), 'Last Ticket should be equal');
		$this->assertEquals(2, $column->getTickets()->count(), 'There should be 2 tickets');

		$column->removeTicket($firstTicket);

		$this->assertEquals(1, $column->getTickets()->count(), 'There should be 1 ticket');
		$this->assertEquals($secondTicket, $column->getTickets()->first(), 'Second ticket should be equal');
	}

	/**
	 * @test
	 */
	public function getIsFirst(){
		$board = new Board();
		$firstColumn = new Column();
		$firstColumn->setSort(1);
		$secondColumn = new Column();
		$secondColumn->setSort(2);

		$board->addColumn($firstColumn);
		$firstColumn->setBoard($board);
		$board->addColumn($secondColumn);
		$secondColumn->setBoard($board);

		$this->assertTrue($firstColumn->getIsFirst(), 'Should be the first Column');
		$this->assertFalse($secondColumn->getIsFirst(), 'Should not be the first Column');
	}

	/**
	 * @test
	 */
	public function getIsLast(){
		$board = new Board();
		$firstColumn = new Column();
		$firstColumn->setSort(1);
		$secondColumn = new Column();
		$secondColumn->setSort(2);

		$board->addColumn($firstColumn);
		$firstColumn->setBoard($board);
		$board->addColumn($secondColumn);
		$secondColumn->setBoard($board);

		$this->assertTrue($secondColumn->getIsLast(), 'Should be the last Column');
		$this->assertFalse($firstColumn->getIsLast(), 'Should not be the last Column');
	}

	/**
	 * @test
	 */
	public function getColumnWidth(){
		$board = new Board();
		$firstColumn = new Column();
		$firstColumn->setSort(1);
		$secondColumn = new Column();
		$secondColumn->setSort(2);

		$board->addColumn($firstColumn);
		$firstColumn->setBoard($board);
		$board->addColumn($secondColumn);
		$secondColumn->setBoard($board);

		$this->assertEquals(6.0, $firstColumn->getColumnWith());
	}
}

?>