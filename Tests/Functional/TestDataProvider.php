<?php
namespace Witte\Kanban\Tests\Functional;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use \Witte\Kanban\Domain\Model\Board;
use \Witte\Kanban\Domain\Model\Column;
use \Witte\Kanban\Domain\Model\Ticket;

/**
 * TestDataProvider
 */
class TestDataProvider {

	/**
	 * @var \Witte\Kanban\Domain\Repository\ColumnRepository
	 */
	protected $columnRepository;

	/**
	 * @var \Witte\Kanban\Domain\Repository\TicketRepository
	 */
	protected $ticketRepository;
	/**
	 * @var \Witte\Kanban\Domain\Repository\BoardRepository
	 */
	protected $boardRepository;

	/**
	 * @var \TYPO3\Flow\Object\ObjectManagerInterface
	 */
	protected $objectManager;


	public function __construct(\TYPO3\Flow\Object\ObjectManagerInterface $objectManager){
		$this->objectManager = $objectManager;
		$this->columnRepository = $this->objectManager->get('\Witte\Kanban\Domain\Repository\ColumnRepository');
		$this->ticketRepository = $this->objectManager->get('\Witte\Kanban\Domain\Repository\TicketRepository');
		$this->boardRepository = $this->objectManager->get('\Witte\Kanban\Domain\Repository\BoardRepository');
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Board
	 */
	public function getBoard(){
		$board = new Board();
		$board->setTitle('Testboard');
		$this->boardRepository->add($board);
		return $board;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Column
	 */
	public function getColumn(){
		$column = new Column();
		$column->setTitle('Test');
		$column->setLimitValue(0);
		$column->setSort(0);
		$this->columnRepository->add($column);
		return $column;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Ticket
	 */
	public function getTicket(){
		$ticket = new Ticket();
		$ticket->setTitle('Kanban board');
		$ticket->setDescription('Create a new Kanban board');
		$this->ticketRepository->add($ticket);
		return $ticket;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Column
	 */
	public function getColumnWithTicket(){
		$column = $this->getColumn();
		$ticket = $this->getTicket();
		$column->addTicket($ticket);
		$ticket->setColumn($column);
		$this->ticketRepository->update($ticket);
		$this->columnRepository->update($column);
		return $column;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Column
	 */
	public function getColumnWithSubColumn(){
		$column = $this->getColumn();
		$subColumn = $this->getColumn();
		$column->addSubColumn($subColumn);
		$subColumn->setParentColumn($column);
		$this->columnRepository->update($subColumn);
		$this->columnRepository->update($column);
		return $column;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Column
	 */
	public function getColumnWithSubColumns(){
		$column = $this->getColumn();
		for($i=0; $i < 3; $i++){
			$subColumn = $this->getColumn();
			$column->addSubColumn($subColumn);
			$subColumn->setParentColumn($column);
			$this->columnRepository->update($subColumn);
		}
		$this->columnRepository->update($column);
		return $column;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Column
	 */
	public function getColumnWithSubColumnsWithSubColumns(){
		$column = $this->getColumn();
		for($i=0; $i < 3; $i++){
			$subColumn = $this->getColumnWithSubColumns();
			$column->addSubColumn($subColumn);
			$subColumn->setParentColumn($column);
			$this->columnRepository->update($subColumn);
		}
		$this->columnRepository->update($column);
		return $column;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Column
	 */
	public function getColumnWithSubColumnWithTicket(){
		$column = $this->getColumnWithSubColumn();
		$subColumn = $column->getSubColumns()->first();
		$ticket = $this->getTicket();
		$ticket->setColumn($subColumn);
		$subColumn->addTicket($ticket);
		$this->ticketRepository->update($ticket);
		$this->columnRepository->update($subColumn);
		return $column;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Board
	 */
	public function getBoardWithColumnsSubColumns(){
		$board = $this->getBoard();
		for($i=0; $i < 3; $i++){
			$column = $this->getColumnWithSubColumn();
			$column->setBoard($board);
			$board->addColumn($column);
			$this->columnRepository->update($column);
		}
		$this->boardRepository->update($board);
		return $board;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Board
	 */
	public function getBoardWithColumns(){
		$board = $this->getBoard();
		for($i=0; $i < 3; $i++){
			$column = $this->getColumn();
			$column->setBoard($board);
			$board->addColumn($column);
			$this->columnRepository->update($column);
		}
		$this->boardRepository->update($board);
		return $board;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Board
	 */
	public function getBoardWithColumnsSubColumnsTicket(){
		$board = $this->getBoard();
		// create three columns with subColumns and tickets
		for($i=0; $i < 3; $i++){
			$column = $this->getColumnWithSubColumnWithTicket();
			$column->setBoard($board);
			$board->addColumn($column);
			$this->columnRepository->update($column);
		}
		$this->boardRepository->update($board);
		return $board;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Board
	 */
	public function getBoardWithColumnsTicketSubColumnsTicket(){
		$board = $this->getBoard();
		// create three columns with subColumns and tickets
		for($i=0; $i < 3; $i++){
			$column = $this->getColumnWithSubColumnWithTicket();
			$ticket = $this->getTicket();
			$ticket->setColumn($column);
			$column->addTicket($ticket);
			$column->setBoard($board);
			$board->addColumn($column);
			$this->ticketRepository->update($ticket);
			$this->columnRepository->update($column);
		}
		$this->boardRepository->update($board);
		return $board;
	}
}
?>