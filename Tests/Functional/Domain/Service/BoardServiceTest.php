<?php
namespace Witte\Kanban\Tests\Functional\Domain\Service;

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
class BoardServiceTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = TRUE;

	/**
	 * @var \Witte\Kanban\Tests\Functional\TestDataProvider
	 */
	protected $testDataProvider;

	/**
	 * @var \Witte\Kanban\Domain\Service\BoardService
	 */
	protected $boardService;

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
		/** @var $boardService \Witte\Kanban\Domain\Service\BoardService */
		$this->boardService = $this->objectManager->get('\Witte\Kanban\Domain\Service\BoardService');
	}


	/**
	 * @test
	 */
	public function createBoardWithDependencies(){
		// because a not persisted board is needed here
		$board = new Board();
		$board->setTitle('test');
		$this->boardService->createBoardWithDependencies($board);
		$this->persistenceManager->persistAll();
		$this->assertEquals(3, $board->getColumns()->count(), 'Board should have 3 columns');
	}

	/**
	 * @test
	 */
	public function getBoardByTicket(){
		$board = $this->testDataProvider->getBoardWithColumnsTicketSubColumnsTicket();
		/** @var $ticketInColumn \Witte\Kanban\Domain\Model\Ticket */
		$ticketInColumn = $board->getColumns()->first()->getTickets()->first();
		$this->assertEquals($board, $this->boardService->getBoardByTicket($ticketInColumn), 'Board should be equal by column ticket');

		/** @var $ticketInSubColumn \Witte\Kanban\Domain\Model\Ticket */
		$ticketInSubColumn = $board->getColumns()->first()->getSubColumns()->first()->getTickets()->first();
		$this->assertEquals($board, $this->boardService->getBoardByTicket($ticketInSubColumn), 'Board should be equal by subColumn ticket');
	}

	/**
	 * @test
	 */
	public function getBoardByColumn(){
		$board = $this->testDataProvider->getBoardWithColumnsSubColumns();
		/** @var $column \Witte\Kanban\Domain\Model\Column */
		$column = $board->getColumns()->first();
		$this->assertEquals($board, $this->boardService->getBoardByColumn($column), 'Board should be equal by column');

		/** @var $subColumn \Witte\Kanban\Domain\Model\Column */
		$subColumn = $board->getColumns()->first()->getSubColumns()->first();
		$this->assertEquals($board, $this->boardService->getBoardByColumn($subColumn), 'Board should be equal by subColumn');
	}

	/**
	 * @test
	 */
	public function getFirstLowestLevelColumn(){
		$board = $this->testDataProvider->getBoardWithColumnsSubColumns();
		$this->assertEquals($board->getColumns()->first()->getSubColumns()->first() , $this->boardService->getFirstLowestLevelColumn($board), 'Column should be equal');
		$this->assertNotEquals($board->getColumns()->first(), $this->boardService->getFirstLowestLevelColumn($board), 'Should not be equal');

		// test with board without columns
		$boardWithoutColumns = $this->testDataProvider->getBoard();
		$this->assertFalse($this->boardService->getFirstLowestLevelColumn($boardWithoutColumns), 'Should return false');
	}

	/**
	 * @test
	 */
	public function getLastLowestLevelColumn(){
		$board = $this->testDataProvider->getBoardWithColumnsSubColumns();
		$this->assertEquals($board->getColumns()->last()->getSubColumns()->last(), $this->boardService->getLastLowestLevelColumn($board), 'Should be equal');
		$this->assertNotEquals($board->getColumns()->last(), $this->boardService->getLastLowestLevelColumn($board), 'Should not be equal');

		// test with board without columns
		$boardWithoutColumns = $this->testDataProvider->getBoard();
		$this->assertFalse($this->boardService->getLastLowestLevelColumn($boardWithoutColumns), 'Should be false');
	}
}

?>