<?php
namespace Witte\Kanban\Tests\Unit\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 * Copyright (C) 2012 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

use \Witte\Kanban\Domain\Model\Ticket;
/**
 * Testcase for Ticket
 */
class TicketTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function getSetTitle(){
		$ticket = new Ticket();
		$ticket->setTitle('Awesome ticket');
		$this->assertEquals('Awesome ticket', $ticket->getTitle());
	}

	/**
	 * @test
	 */
	public function getSetDescription(){
		$ticket = new Ticket();
		$description = 'This is the awesome description of my ticket';
		$ticket->setDescription($description);
		$this->assertEquals($description, $ticket->getDescription());
	}

	/**
	 * @test
	 */
	public function getSetVersion(){
		$ticket = new Ticket();
		$ticket->setVersion('v0.1');
		$this->assertEquals('v0.1', $ticket->getVersion());
	}

	/**
	 * @test
	 */
	public function getSetCreated(){
		$mockDateTime = $this->getMock('\DateTime');
		$ticket = new Ticket();
		$ticket->setCreated($mockDateTime);
		$this->assertEquals($mockDateTime, $ticket->getCreated());
	}

	/**
	 * @test
	 */
	public function getSetStarted(){
		$mockDateTime = $this->getMock('\DateTime');
		$ticket = new Ticket();
		$ticket->setStarted($mockDateTime);
		$this->assertEquals($mockDateTime, $ticket->getStarted());
	}

	/**
	 * @test
	 */
	public function getSetMoved(){
		$mockDateTime = $this->getMock('\DateTime');
		$ticket = new Ticket();
		$ticket->setMoved($mockDateTime);
		$this->assertEquals($mockDateTime, $ticket->getMoved());
	}

	/**
	 * @test
	 */
	public function getSetColumn(){
		$mockColumn = $this->getMock('\Witte\Kanban\Domain\Model\Column');
		$ticket = new Ticket();
		$ticket->setColumn($mockColumn);
		$this->assertEquals($mockColumn, $ticket->getColumn());
	}

	/**
	 * @test
	 */
	public function getSetBoard(){
		$mockBoard = $this->getMock('\Witte\Kanban\Domain\Model\Board');
		$ticket = new Ticket();
		$ticket->setBoard($mockBoard);
		$this->assertEquals($mockBoard, $ticket->getBoard());
	}
}
?>