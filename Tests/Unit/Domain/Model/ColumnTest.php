<?php
namespace Witte\Kanban\Tests\Unit\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use \Witte\Kanban\Domain\Model\Column;
/**
 * Testcase for Column
 */
class ColumnTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function getSetTitle(){
		$column = new Column();
		$column->setTitle('My awesome Column');
		$this->assertEquals('My awesome Column', $column->getTitle());
	}

	/**
	 * @test
	 */
	public function getSetSort(){
		$column = new Column();
		$column->setSort(5);
		$this->assertEquals(5, $column->getSort());
	}

	/**
	 * @test
	 */
	public function getSetCreated(){
		$mockDateTime = $this->getMock('\DateTime');
		$column = new Column();
		$column->setCreated($mockDateTime);
		$this->assertEquals($mockDateTime, $column->getCreated());
	}

	/**
	 * @test
	 */
	public function getSetLimitValue(){
		$column = new Column();
		$column->setLimitValue(7);
		$this->assertEquals(7, $column->getLimitValue());
	}

	/**
	 * @test
	 */
	public function getSetBoard(){
		$mockBoard = $this->getMock('\Witte\Kanban\Domain\Model\Board');
		$column = new Column();
		$column->setBoard($mockBoard);
		$this->assertEquals($mockBoard, $column->getBoard());
	}

	/**
	 * @test
	 */
	public function getSetParentColumn(){
		$parentColumn = new Column();
		$column = new Column();
		$column->setParentColumn($parentColumn);
		$this->assertEquals($parentColumn, $column->getParentColumn());
	}

	/**
	 * @test
	 */
	public function getSetTickets(){
		$mockArrayCollection = $this->getMock('Doctrine\Common\Collections\ArrayCollection');
		$column = new Column();
		$column->setTickets($mockArrayCollection);
		$this->assertEquals($mockArrayCollection, $column->getTickets());
	}

	/**
	 * @test
	 */
	public function getSetSubColumns(){
		$mockArrayCollection = $this->getMock('Doctrine\Common\Collections\ArrayCollection');
		$column = new Column();
		$column->setSubColumns($mockArrayCollection);
		$this->assertEquals($mockArrayCollection, $column->getSubColumns());
	}
}
?>