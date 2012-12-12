<?php
namespace Witte\Kanban\Tests\Functional\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use \Witte\Kanban\Domain\Model\Board;
use \Witte\Kanban\Domain\Model\Column;
use \Witte\Kanban\Domain\Model\Ticket;
/**
 * Testcase for Board
 */
class ColumnServiceTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = TRUE;

	/**
	 * @var \Witte\Kanban\Tests\Functional\TestDataProvider
	 */
	protected $testDataProvider;

	/**
	 * @var \Witte\Kanban\Domain\Service\ColumnService
	 */
	protected $columnService;

	/**
	 * @var \Witte\Kanban\Domain\Repository\BoardRepository
	 */
	protected $boardRepository;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		if (!$this->persistenceManager instanceof \TYPO3\Flow\Persistence\Doctrine\PersistenceManager) {
			$this->markTestSkipped('Doctrine persistence is not enabled');
		}
		/** @var testDataProvider \Witte\Kanban\Tests\Functional\TestDataProvider */
		$this->testDataProvider = new \Witte\Kanban\Tests\Functional\TestDataProvider($this->objectManager);
		/** @var $columnService \Witte\Kanban\Domain\Service\ColumnService */
		$this->columnService = $this->objectManager->get('\Witte\Kanban\Domain\Service\ColumnService');

		$this->boardRepository = $this->objectManager->get('\Witte\Kanban\Domain\Repository\BoardRepository');
	}

	/**
	 * @test
	 */
	public function isFirstColumnInBoard(){
		$board = $this->testDataProvider->getBoardWithColumnsSubColumns();
		$firstColumn = $board->getColumns()->first()->getSubColumns()->first();
		$this->assertTrue($this->columnService->isFirstColumnInBoard($firstColumn), 'Should be true');

		$lastColumnFirstLevel = $board->getColumns()->last();
		$this->assertFalse($this->columnService->isFirstColumnInBoard($lastColumnFirstLevel), 'Should be false, last column');

		$firstColumnFirstLevel = $board->getColumns()->first();
		$this->assertFalse($this->columnService->isFirstColumnInBoard($firstColumnFirstLevel, 'Should be false, first column first level'));
	}

	/**
	 * @test
	 */
	public function isLastColumnInBoard(){
		$board = $this->testDataProvider->getBoardWithColumnsSubColumns();
		$firstColumn = $board->getColumns()->first()->getSubColumns()->first();
		$this->assertFalse($this->columnService->isLastColumnInBoard($firstColumn), 'Should be false');

		$lastColumn = $board->getColumns()->last()->getSubColumns()->last();
		$this->assertTrue($this->columnService->isLastColumnInBoard($lastColumn), 'Should be false, last column');

		$lastColumnFirstLevel = $board->getColumns()->last();
		$this->assertFalse($this->columnService->isLastColumnInBoard($lastColumnFirstLevel, 'Should be false, last column first level'));
	}

	/**
	 * @test
	 */
	public function addNewColumnInBoard(){
		$board = $this->testDataProvider->getBoard();
		$column = new Column();
		$column->setTitle('test');
		$column->setBoard($board);

		$this->columnService->addNewColumn($column);

		$this->persistenceManager->persistAll();

		$this->assertEquals($column, $this->boardRepository->findAll()->getFirst()->getColumns()->first());
	}

	/**
	 * @test
	 */
	public function addNewColumnInColumn(){
		$board = $this->testDataProvider->getBoardWithColumns();
		$column = new Column();
		$column->setTitle('Test');
		$column->setParentColumn($board->getColumns()->first());

		$this->columnService->addNewColumn($column);

		$this->persistenceManager->persistAll();
		$this->assertEquals($column, $this->boardRepository->findAll()->getFirst()->getColumns()->first()->getSubColumns()->first());
	}

	/**
	 * @test
	 */
	public function removeColumnWithDependencies(){
		/** @todo implement */
		$this->markTestIncomplete('Not sure about best practise here');
	}

	/**
	 * @test
	 */
	public function getFirstLowestLevelColumnByColumn(){
		$columnWithSubColumnsWithSubColumns = $this->testDataProvider->getColumnWithSubColumnsWithSubColumns();

		$firstSubColumn = $columnWithSubColumnsWithSubColumns->getSubColumns()->first();
		$lastSubColumn = $columnWithSubColumnsWithSubColumns->getSubColumns()->last();
		$firstSubColumnSubColumn = $columnWithSubColumnsWithSubColumns->getSubColumns()->first()->getSubColumns()->first();
		$otherSubColumnSubColumn = $columnWithSubColumnsWithSubColumns->getSubColumns()->first()->getSubColumns()->last();

		$this->assertNotEquals($firstSubColumn, $this->columnService->getFirstLowestLevelColumnByColumn($columnWithSubColumnsWithSubColumns));
		$this->assertNotEquals($lastSubColumn, $this->columnService->getFirstLowestLevelColumnByColumn($columnWithSubColumnsWithSubColumns));
		$this->assertEquals($firstSubColumnSubColumn, $this->columnService->getFirstLowestLevelColumnByColumn($columnWithSubColumnsWithSubColumns));
		$this->assertNotEquals($otherSubColumnSubColumn, $this->columnService->getFirstLowestLevelColumnByColumn($columnWithSubColumnsWithSubColumns));
	}

	/**
	 * @test
	 */
	public function getLastLowestLevelColumnByColumn(){
		$columnWithSubColumnsWithSubColumns = $this->testDataProvider->getColumnWithSubColumnsWithSubColumns();

		$firstSubColumn = $columnWithSubColumnsWithSubColumns->getSubColumns()->first();
		$lastSubColumn = $columnWithSubColumnsWithSubColumns->getSubColumns()->last();
		$firstSubColumnSubColumn = $columnWithSubColumnsWithSubColumns->getSubColumns()->first()->getSubColumns()->first();
		$lastSubColumnSubColumn = $columnWithSubColumnsWithSubColumns->getSubColumns()->last()->getSubColumns()->last();

		$this->assertNotEquals($firstSubColumn, $this->columnService->getLastLowestLevelColumnByColumn($columnWithSubColumnsWithSubColumns));
		$this->assertNotEquals($lastSubColumn, $this->columnService->getLastLowestLevelColumnByColumn($columnWithSubColumnsWithSubColumns));
		$this->assertNotEquals($firstSubColumnSubColumn, $this->columnService->getLastLowestLevelColumnByColumn($columnWithSubColumnsWithSubColumns));
		$this->assertEquals($lastSubColumnSubColumn, $this->columnService->getLastLowestLevelColumnByColumn($columnWithSubColumnsWithSubColumns));
	}

	/**
	 * @test
	 */
	public function getPreviousColumn(){
		$columnWithSubColumnsWithSubColumns = $this->testDataProvider->getColumnWithSubColumnsWithSubColumns();
		$previousColumn = $columnWithSubColumnsWithSubColumns->getSubColumns()->get(0)->getSubColumns()->last();
		$column = $columnWithSubColumnsWithSubColumns->getSubColumns()->get(1)->getSubColumns()->first();
		$this->assertNotEquals($previousColumn, $column);
		$this->assertEquals($previousColumn, $this->columnService->getPreviousColumn($column));
	}

	/**
	 * @test
	 */
	public function getNextColumn(){
		$columnWithSubColumnsWithSubColumns = $this->testDataProvider->getColumnWithSubColumnsWithSubColumns();
		$previousColumn = $columnWithSubColumnsWithSubColumns->getSubColumns()->get(0)->getSubColumns()->last();
		//$this->assertEquals(123, $columnWithSubColumnsWithSubColumns->getSubColumns()->get(1)->getSubColumns()->first());
		$column = $columnWithSubColumnsWithSubColumns->getSubColumns()->get(1)->getSubColumns()->first();
		$this->assertNotEquals($previousColumn, $column);
		$this->assertEquals($column, $this->columnService->getNextColumn($previousColumn));
	}

	/**
	 * @test
	 */
	public function getSiblings(){
		/** @todo implement */
		$this->markTestIncomplete('Not sure about best practise here');

		$columnWithSubColumnsWithSubColumns = $this->testDataProvider->getColumnWithSubColumnsWithSubColumns();
		$siblingsFirstLevel = $columnWithSubColumnsWithSubColumns->getSubColumns();
		$siblingsSecondLevel = $columnWithSubColumnsWithSubColumns->getSubColumns()->first()->getSubColumns();
		$this->persistenceManager->persistAll();
		$accessibleMockColumnService = $this->getAccessibleMock('\Witte\Kanban\Domain\Service\ColumnService', array('getSiblings'), array(), '', FALSE);
		$this->assertEquals($siblingsFirstLevel, $accessibleMockColumnService->_call('getSiblings', $columnWithSubColumnsWithSubColumns->getSubColumns()->first()));
	}

	/**
	 * @test
	 */
	public function getColumnWidth(){
		$columnWithSubColumnsWithSubColumns = $this->testDataProvider->getColumnWithSubColumnsWithSubColumns();
		$this->assertEquals(4, $this->columnService->getColumnWidth($columnWithSubColumnsWithSubColumns->getSubColumns()->first()));
	}

	/**
	 * @test
	 */
	public function removeColumn(){
		$boardWithColumnsSubColumnsTicket = $this->testDataProvider->getBoardWithColumnsSubColumnsTicket();
		$this->assertEquals(0, $boardWithColumnsSubColumnsTicket->getColumns()->first()->getTickets()->count());
		$this->assertEquals(1, $boardWithColumnsSubColumnsTicket->getColumns()->first()->getSubColumns()->first()->getTickets()->count());
		$this->columnService->removeColumn($boardWithColumnsSubColumnsTicket->getColumns()->first()->getSubColumns()->first());
		$this->assertEquals(0, $boardWithColumnsSubColumnsTicket->getColumns()->first()->getSubColumns()->count());
		$this->assertEquals(1, $boardWithColumnsSubColumnsTicket->getColumns()->first()->getTickets()->count());


	}
}

?>