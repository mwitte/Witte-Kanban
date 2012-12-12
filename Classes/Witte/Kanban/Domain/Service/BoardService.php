<?php
namespace Witte\Kanban\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use \Witte\Kanban\Domain\Model\Board;
use \Witte\Kanban\Domain\Model\Column;
use \Witte\Kanban\Domain\Model\Ticket;
use \Witte\Kanban\Domain\Service\AbstractService;

/**
 * Service
 *
 * @Flow\Scope("singleton")
 */
class BoardService extends AbstractService {

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\ColumnService
	 */
	protected $columnService;

	/**
	 * Creates a new default board
	 *
	 * @param \Witte\Kanban\Domain\Model\Board $board
	 */
	public function createBoardWithDependencies(Board $board){

		$backlog = new Column();
		$backlog->setTitle('Backlog');
		$backlog->setSort(0);
		$backlog->setBoard($board);
		$this->columnRepository->add($backlog);
		$board->addColumn($backlog);

		$onGoing = new Column;
		$onGoing->setTitle('On going');
		$onGoing->setSort(1);
		$onGoing->setBoard($board);
		$this->columnRepository->add($onGoing);
		$board->addColumn($onGoing);

		$done = new Column();
		$done->setTitle('Done');
		$done->setSort(2);
		$done->setBoard($board);
		$this->columnRepository->add($done);
		$board->addColumn($done);

		$ticket = new Ticket();
		$ticket->setTitle('Kanban board');
		$ticket->setDescription('Create a new Kanban board');
		$ticket->setColumn($done);
		$this->ticketRepository->add($ticket);

		$this->boardRepository->add($board);
	}

	/**
	 * Finds the related board to a ticket
	 *
	 * @param Ticket $ticket
	 * @return \Witte\Kanban\Domain\Model\Board
	 */
	public function getBoardByTicket(Ticket $ticket){

		if($ticket->getColumn()){
			return $this->getBoardByColumn($ticket->getColumn());
		}else{
			return $ticket->getBoard();
		}
	}

	/**
	 * Finds the related board to a column
	 *
	 * @param Column $column
	 * @return \Witte\Kanban\Domain\Model\Board
	 */
	public function getBoardByColumn(Column $column){
		if($column->getBoard()){
			return $column->getBoard();
		}else{
			return $this->getBoardByColumn($column->getParentColumn());
		}
	}

	/**
	 * Finds the lowest nested first column of a board
	 *
	 * @param Board $board
	 * @return bool|\Witte\Kanban\Domain\Model\Column
	 */
	public function getFirstLowestLevelColumn(Board $board){
		if($board->getColumns()->count() > 0){
			return $this->columnService->getFirstLowestLevelColumnByColumn($board->getColumns()->first());
		}else{
			return FALSE;
		}
	}

	/**
	 * Finds the lowest nested last column of a board
	 *
	 * @param Board $board
	 * @return bool|\Witte\Kanban\Domain\Model\Column
	 */
	public function getLastLowestLevelColumn(Board $board){
		if($board->getColumns()->count() > 0){
			return $this->columnService->getLastLowestLevelColumnByColumn($board->getColumns()->last());
		}else{
			return FALSE;
		}
	}

	public function deleteBoard(Board $board){
		// @todo
	}
}
?>