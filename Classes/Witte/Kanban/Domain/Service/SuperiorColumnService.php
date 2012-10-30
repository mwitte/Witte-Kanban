<?php
namespace Witte\Kanban\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use \Witte\Kanban\Domain\Model\Board;
use \Witte\Kanban\Domain\Model\SuperiorColumn;
use \Witte\Kanban\Domain\Model\SubColumn;
use \Witte\Kanban\Domain\Service\AbstractService;

/**
 * Service
 *
 * @Flow\Scope("singleton")
 */
class SuperiorColumnService extends AbstractService {

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\TicketService
	 */
	protected $ticketService;

	/**
	 * @param SuperiorColumn $superiorColumn
	 * @return SuperiorColumn
	 */
	public function getPreviousSuperiorColumn(SuperiorColumn $superiorColumn){
		$superiorColumns = $superiorColumn->getBoard()->getSuperiorColumns();
		// if the given superiorColumn is not the first
		if($superiorColumns->indexOf($superiorColumn) > 0){
			$previousSuperiorColumn = $superiorColumns->get($superiorColumns->indexOf($superiorColumn) - 1);
		}else{
			$previousSuperiorColumn = FALSE;
		}
		return $previousSuperiorColumn;
	}

	public function getNextSuperiorColumn(SuperiorColumn $superiorColumn){
		$superiorColumns = $superiorColumn->getBoard()->getSuperiorColumns();
		// if the given superiorColumn is not the last
		if($superiorColumns->last() != $superiorColumn){
			$nextSuperiorColumn = $superiorColumns->get($superiorColumns->indexOf($superiorColumn) + 1);
		}else{
			$nextSuperiorColumn = FALSE;
		}
		return $nextSuperiorColumn;
	}

	/**
	 * @param SuperiorColumn $superiorColumn
	 */
	public function createSuperiorColumnDependencies(SuperiorColumn $superiorColumn){

		$subColumnService = new SubColumnService();

		$subColumn = new SubColumn();
		$subColumn->setTitle('doing');
		$subColumn->setSuperiorColumn($superiorColumn);
		$superiorColumn->addSubColumn($subColumn);
		$subColumnService->createSubColumnDependencies($subColumn);


		$this->superiorColumnRepository->add($superiorColumn);
	}

	/**
	 * @param SuperiorColumn $superiorColumn
	 */
	public function removeSuperiorColumnDependencies(SuperiorColumn $superiorColumn){

		if($superiorColumn->getBoard()->getSuperiorColumns()->first() == $superiorColumn ||
			$superiorColumn->getBoard()->getSuperiorColumns()->last() == $superiorColumn){
			return FALSE;
		}

		/** @var \Witte\Kanban\Domain\Model\SubColumn $subColumn */
		foreach($superiorColumn->getSubColumns() as $subColumn){
			/** @var \Witte\Kanban\Domain\Model\Ticket $ticket */
			foreach($subColumn->getTickets() as $ticket){
				$this->ticketService->moveTicketToPreviousSubColumn($ticket);
			}
			$this->subColumnRepository->remove($subColumn);
		}
		$board = $superiorColumn->getBoard();
		$board->removeSuperiorColumn($superiorColumn);
		$this->superiorColumnRepository->remove($superiorColumn);

		$superiorColumn->setSort($board->getSuperiorColumns()->last()->getSort() + 1);
		$this->sortSuperiorColumnsByNewSuperiorColumn($board, $superiorColumn);
		return TRUE;
	}

	/**
	 * @param SuperiorColumn $superiorColumn
	 * @param Board $board
	 * @return bool
	 */
	public function addNewSuperiorColumnToBoard(SuperiorColumn $superiorColumn, Board $board){
		if($board->getSuperiorColumns()->count() < $this->settings['TwitterBootstrap']['Columns']){
			$this->sortSuperiorColumnsByNewSuperiorColumn($board, $superiorColumn);

			$board->addSuperiorColumn($superiorColumn);

			$this->createSuperiorColumnDependencies($superiorColumn);

			$superiorColumn->setBoard($board);

			$this->boardRepository->update($board);
			return true;
		}
		return false;
	}

	protected function sortSuperiorColumnsByNewSuperiorColumn(Board $board, SuperiorColumn $newSuperiorColumn){
		$superiorColumns = $board->getSuperiorColumns();

		/** @var SuperiorColumn $superiorColumn */
		$count = 0;
		foreach($superiorColumns as $superiorColumn){
			// if the new superiorColumn affects the iterated superiorColumn
			if($superiorColumn->getSort() >= $newSuperiorColumn->getSort()){
				// increment sort value for this column
				$superiorColumn->setSort($count + 1 );
			}else{
				$superiorColumn->setSort($count);
			}
			$this->superiorColumnRepository->update($superiorColumn);
			$count++;
		}
	}

	/**
	 * @param Board $board
	 * @return float
	 */
	public function getQuotientByBoard(Board $board){
		return $this->getQuotient($board->getSuperiorColumns()->count());
	}

	public function isSuperiorColumnFirst(SuperiorColumn $superiorColumn){
		if($superiorColumn->getBoard()->getSuperiorColumns()->first() == $superiorColumn ){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function isSuperiorColumnLast(SuperiorColumn $superiorColumn){
		if($superiorColumn->getBoard()->getSuperiorColumns()->last() == $superiorColumn ){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getTicketsCount(SuperiorColumn $superiorColumn){
		$count = 0;
		foreach($superiorColumn->getSubColumns() as $subColumn){
			$count = $count + $subColumn->getTickets()->count();
		}
		return $count;
	}
}
?>