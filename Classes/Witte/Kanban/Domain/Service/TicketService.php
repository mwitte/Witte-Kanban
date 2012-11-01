<?php
namespace Witte\Kanban\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use \Witte\Kanban\Domain\Model\Board;
use \Witte\Kanban\Domain\Model\Ticket;
use \Witte\Kanban\Domain\Model\Column;
use \Witte\Kanban\Domain\Service\AbstractService;

/**
 * Service
 *
 * @Flow\Scope("singleton")
 */
class TicketService extends AbstractService {

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\ColumnService
	 */
	protected $columnService;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\BoardService
	 */
	protected $boardService;

	/**
	 * Move a ticket to the next column
	 *
	 * @param Ticket $ticket
	 * @return bool
	 */
	public function moveTicketToNextColumn(Ticket $ticket){
		$nextColumn = $this->columnService->getNextColumn($ticket->getColumn());
		if($nextColumn){
			$this->moveTicketToColumn($ticket, $nextColumn);
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Move a ticket to the previous column
	 *
	 * @param Ticket $ticket
	 * @return bool
	 */
	public function moveTicketToPreviousColumn(Ticket $ticket){
		$previousColumn = $this->columnService->getPreviousColumn($ticket->getColumn());
		if($previousColumn){
			$this->moveTicketToColumn($ticket, $previousColumn);
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Move a ticket to to the parent column
	 *
	 * @param Ticket $ticket
	 * @return bool
	 */
	public function moveTicketToParentColumn(Ticket $ticket){
		if($ticket->getColumn()->getParentColumn()){
			$this->moveTicketToColumn($ticket, $ticket->getColumn()->getParentColumn());
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Move a ticket to the given column
	 *
	 * @param Ticket $ticket
	 * @param Column $column
	 */
	public function moveTicketToColumn(Ticket $ticket, Column $column){

		// ticket is moving, so set current date for moved
		$ticket->setMoved(new \DateTime());

		// remove ticket from old column
		$oldColumn = $ticket->getColumn();
		$oldColumn->removeTicket($ticket);
		$this->columnRepository->update($oldColumn);

		$firstColumn = $this->boardService->getFirstLowestLevelColumn($this->boardService->getBoardByTicket($ticket));
		// if old place was first column set the started date
		if($oldColumn == $firstColumn){
			$ticket->setStarted(new \DateTime());
		}

		$ticket->setColumn($column);
		$column->addTicket($ticket);

		$this->columnRepository->update($column);
		$this->ticketRepository->update($ticket);
	}

	/**
	 * Creates a ticket in the given column
	 *
	 * @param Ticket $ticket
	 * @param Column $column
	 */
	public function createTicketInColumn(Ticket $ticket, Column $column){
		$ticket->setColumn($column);
		$column->addTicket($ticket);

		$this->ticketRepository->add($ticket);
		$this->columnRepository->update($column);
	}

	/**
	 * Creates a ticket in the given board
	 *
	 * @param Ticket $ticket
	 * @param Board $board
	 */
	public function createTicketInBoard(Ticket $ticket, Board $board){
		// get the first column of the board
		$column = $this->boardService->getFirstLowestLevelColumn($board);
		$this->createTicketInColumn($ticket, $column);
	}

	/**
	 * Removes a ticket from the board and pushes it into the archive
	 *
	 * @param Ticket $ticket
	 */
	public function archiveTicket(Ticket $ticket){
		$board = $this->boardService->getBoardByTicket($ticket);
		$board->addToTicketArchive($ticket);

		$column = $ticket->getColumn();
		$column->removeTicket($ticket);

		$ticket->setColumn(null);
		$ticket->setBoard($board);

		$this->boardRepository->update($board);
		$this->columnRepository->update($column);
		$this->ticketRepository->update($ticket);
	}
}
?>