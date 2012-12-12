<?php
namespace Witte\Kanban\Tests\Unit\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 * Copyright (C) 2012 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

use \Witte\Kanban\Domain\Model\Board;
/**
 * Testcase for Board
 */
class BoardTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function getSetTitle(){
		$board = new Board();
		$board->setTitle('My new Board');
		$this->assertEquals('My new Board', $board->getTitle());
	}

	/**
	 * @test
	 */
	public function getSetCreated(){
		$mockDateTime = $this->getMock('\DateTime');
		$board = new Board();
		$board->setCreated($mockDateTime);
		$this->assertEquals($mockDateTime, $board->getCreated());
	}

	/**
	 * @test
	 */
	public function getSetColumns(){
		$mockArrayCollection = $this->getMock('Doctrine\Common\Collections\ArrayCollection', array(), array(), '', FALSE);
		$board = new Board();
		$board->setColumns($mockArrayCollection);
		$this->assertEquals($mockArrayCollection, $board->getColumns());
	}

	/**
	 * @test
	 */
	public function getSetTicketArchive(){
		$mockArrayCollection = $this->getMock('Doctrine\Common\Collections\ArrayCollection', array(), array(), '', FALSE);
		$board = new Board();
		$board->setTicketArchive($mockArrayCollection);
		$this->assertEquals($mockArrayCollection, $board->getTicketArchive());
	}
}
?>