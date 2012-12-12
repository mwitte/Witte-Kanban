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
class TicketServiceTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = TRUE;

	/**
	 * @var \Witte\Kanban\Tests\Functional\TestDataProvider
	 */
	protected $testDataProvider;

	/**
	 * @var \Witte\Kanban\Domain\Service\TicketService
	 */
	protected $ticketService;

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
		/** @var $ticketService \Witte\Kanban\Domain\Service\TicketService */
		$this->ticketService = $this->objectManager->get('\Witte\Kanban\Domain\Service\TicketService');

		$this->boardRepository = $this->objectManager->get('\Witte\Kanban\Domain\Repository\BoardRepository');
	}

	/**
	 * @test
	 */
	public function moveTicketToNextColumn(){
		$board = $this->testDataProvider->getBoardWithColumnsSubColumnsTicket();
		$oldTicketColumn = $board->getColumns()->first()->getSubColumns()->first();
		$ticket = $oldTicketColumn->getTickets()->first();
		$newTicketColumn = $board->getColumns()->get(1)->getSubColumns()->first();
		$this->assertTrue($this->ticketService->moveTicketToNextColumn($ticket));
		$this->assertNotEquals($ticket, $oldTicketColumn->getTickets()->first());
		$this->assertEquals($ticket, $newTicketColumn->getTickets()->last());
		$this->assertEquals(2, $newTicketColumn->getTickets()->count());
	}

	/**
	 * @test
	 */
	public function moveTicketToPreviousColumn(){
		$board = $this->testDataProvider->getBoardWithColumnsSubColumnsTicket();
		$newTicketColumn = $board->getColumns()->first()->getSubColumns()->first();
		$oldTicketColumn = $board->getColumns()->get(1)->getSubColumns()->first();
		$ticket = $oldTicketColumn->getTickets()->first();
		$this->assertTrue($this->ticketService->moveTicketToPreviousColumn($ticket));
		$this->assertNotEquals($ticket, $oldTicketColumn->getTickets()->first());
		$this->assertEquals($ticket, $newTicketColumn->getTickets()->last());
		$this->assertEquals(2, $newTicketColumn->getTickets()->count());
	}

	/**
	 * @test
	 */
	public function moveTicketToParentColumn(){
		$board = $this->testDataProvider->getBoardWithColumnsSubColumnsTicket();
		$oldTicketColumn = $board->getColumns()->first()->getSubColumns()->first();
		$ticket = $oldTicketColumn->getTickets()->first();
		$newTicketColumn = $board->getColumns()->first();
		$this->assertTrue($this->ticketService->moveTicketToParentColumn($ticket));
		$this->assertEquals($ticket, $newTicketColumn->getTickets()->first());
		$this->assertEquals(0, $oldTicketColumn->getTickets()->count());
		$this->assertEquals(1, $newTicketColumn->getTickets()->count());
		$this->assertFalse($this->ticketService->moveTicketToParentColumn($ticket));
	}

	/**
	 * @test
	 */
	public function moveTicketToColumn(){
		$board = $this->testDataProvider->getBoardWithColumnsSubColumnsTicket();
		$oldTicketColumn = $board->getColumns()->first()->getSubColumns()->first();
		$ticket = $oldTicketColumn->getTickets()->first();
		$newTicketColumn = $board->getColumns()->first();
		$this->assertNull($this->ticketService->moveTicketToColumn($ticket, $newTicketColumn));
		$this->assertEquals($ticket, $newTicketColumn->getTickets()->first());
		$this->assertEquals(0, $oldTicketColumn->getTickets()->count());
		$this->assertEquals(1, $newTicketColumn->getTickets()->count());
	}

	/**
	 * @test
	 */
	public function createTicketInColumn(){
		$column = $this->testDataProvider->getColumn();
		$ticket = new Ticket();
		$ticket->setTitle('test');
		$ticket->setDescription('Test');
		$this->ticketService->createTicketInColumn($ticket, $column);
		$this->assertEquals($ticket, $column->getTickets()->first());
		$this->assertEquals($column, $ticket->getColumn());
	}
	/**
	 * @test
	 */
	public function createTicketInBoard(){
		$board = $this->testDataProvider->getBoardWithColumnsSubColumns();
		$ticket = new Ticket();
		$ticket->setTitle('test');
		$ticket->setDescription('Test');
		$this->ticketService->createTicketInBoard($ticket, $board);
		$this->assertEquals($ticket, $board->getColumns()->first()->getSubColumns()->first()->getTickets()->first());
		//$this->assertEquals($board, $ticket->getColumn()->getBoard());
	}
	/**
	 * @test
	 */
	public function archiveTicket(){
		$board = $this->testDataProvider->getBoardWithColumnsSubColumnsTicket();
		$ticket = $board->getColumns()->first()->getSubColumns()->first()->getTickets()->first();

		$this->assertEquals(0, $board->getTicketArchive()->count());

		$this->ticketService->archiveTicket($ticket);

		$this->assertEquals($ticket, $board->getTicketArchive()->first());
		$this->assertEquals(null, $ticket->getColumn());
	}
}

?>