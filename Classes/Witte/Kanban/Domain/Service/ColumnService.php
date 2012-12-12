<?php
namespace Witte\Kanban\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use \Witte\Kanban\Domain\Model\Ticket;
use \Witte\Kanban\Domain\Model\Column;
use \Witte\Kanban\Domain\Service\AbstractService;
use \Doctrine\Common\Collections\Collection;

/**
 * Service
 *
 * @Flow\Scope("singleton")
 */
class ColumnService extends AbstractService {

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\TicketService
	 */
	protected $ticketService;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\BoardService
	 */
	protected $boardService;

	/**
	 * Checks if a the given column is the first of the board
	 *
	 * @param Column $column
	 * @return bool
	 */
	public function isFirstColumnInBoard(Column $column){
		$firstColumn = $this->boardService->getFirstLowestLevelColumn($this->boardService->getBoardByColumn($column));

		if($firstColumn == $column){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * Checks if the given column is the last of the board
	 *
	 * @param Column $column
	 * @return bool
	 */
	public function isLastColumnInBoard(Column $column){
		$lastColumn = $this->boardService->getLastLowestLevelColumn($this->boardService->getBoardByColumn($column));

		if($lastColumn == $column){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * Adds a new column
	 *
	 * @param Column $column
	 * @return void
	 */
	public function addNewColumn(Column $column){
		if($column->getBoard()){
			$board = $column->getBoard();
			$board->addColumn($column);
			$this->columnRepository->add($column);
			$this->boardRepository->update($board);
		}else{
			$parentColumn = $column->getParentColumn();
			$parentColumn->addSubColumn($column);
			$this->columnRepository->add($column);
			$this->columnRepository->update($parentColumn);
		}
		$this->resortColumns($this->getSiblings($column), $column);
	}

	/**
	 * Resets the sort property of the given columnCollection.
	 *
	 * @param Collection $columns
	 * @param null|Column $newColumn
	 */
	protected function resortColumns(Collection $columns, Column $newColumn = NULL){
		$iterator = 0;
		/* @var $column Column */
		// iterate over all columns
		foreach($columns as $column){
			// only if it's not the newColumn and the sort equals the newColumn's sort
			if($newColumn && $column != $newColumn && $iterator == $newColumn->getSort()){
				$iterator++;
			}

			if($column != $newColumn){
				$column->setSort($iterator);
			}

			$iterator = $column->getSort() + 1;
			$this->columnRepository->update($column);
		}
	}

	/**
	 * Removes a column with all related columns. Moves the tickets to the parent, previous or next(in this direction) column
	 *
	 * @param Column $column
	 * @return bool
	 */
	public function removeColumnWithDependencies(Column $column){

		// check if the given column is the first/last parent column of the board
		if($column->getBoard() && (
			$column->getBoard()->getColumns()->first() === $column ||
			$column->getBoard()->getColumns()->last() === $column)
		){
			return false;
		}

		// if the column contains subColumns
		if($column->getSubColumns()->count() > 0){
			// iterate recursive over possible subColumns
			foreach($column->getSubColumns() as $subColumn){
				$this->removeColumnWithDependencies($subColumn);
			}
		}
		// iterate over all tickets in this column
		foreach($column->getTickets() as $ticket){
			// try to move ticket to parent Column
			if(!$this->ticketService->moveTicketToParentColumn($ticket)){
				// try to move ticket to previous column
				if(!$this->ticketService->moveTicketToPreviousColumn($ticket)){
					// try to move ticket to next column
					$this->ticketService->moveTicketToNextColumn($ticket);
					/** @todo throw exception */
				}
			}
		}
		$this->columnRepository->remove($column);
		return TRUE;
	}

	/**
	 * Gets the first lowest level column in the given column
	 *
	 * @param Column $column
	 * @return \Witte\Kanban\Domain\Model\Column
	 */
	public function getFirstLowestLevelColumnByColumn(Column $column){
		if($column->getSubColumns()->count() > 0){
			return $this->getFirstLowestLevelColumnByColumn($column->getSubColumns()->first());
		}else{
			return $column;
		}
	}

	/**
	 * Gets the last lowest level column in the given column
	 *
	 * @param Column $column
	 * @return \Witte\Kanban\Domain\Model\Column
	 */
	public function getLastLowestLevelColumnByColumn(Column $column){
		if($column->getSubColumns()->count() > 0){
			return $this->getLastLowestLevelColumnByColumn($column->getSubColumns()->last());
		}else{
			return $column;
		}
	}

	/**
	 * Gets the previous column
	 *
	 * @param Column $column
	 * @return bool
	 */
	public function getPreviousColumn(Column $column){
		$siblings = $this->getSiblings($column);
		// if the given column is the first of the siblings
		if($siblings->first() == $column){
			// if the column has a parent column
			if($column->getParentColumn()){
				// get the previous column for the parent column
				$previousColumnCandidate = $this->getPreviousColumn($column->getParentColumn());
			}else{
				return false;
			}
		}else{
			$previousColumnCandidate = $siblings->get($siblings->indexOf($column) - 1);
		}
		// get the last lowest level column
		$previousColumn = $this->getLastLowestLevelColumnByColumn($previousColumnCandidate);
		return $previousColumn;
	}

	/**
	 * Gets the next column
	 *
	 * @param Column $column
	 * @return bool
	 */
	public function getNextColumn(Column $column){
		$siblings = $this->getSiblings($column);
		// if the given column is the last of the siblings
		if($siblings->last() === $column){
			// if the column has a parent column
			if($column->getParentColumn()){
				// get the next column for the parent column
				$nextColumnCandidate = $this->getNextColumn($column->getParentColumn());
			}else{
				return false;
			}
		}else{
			$nextColumnCandidate = $siblings->get($siblings->indexOf($column) + 1);
		}
		$nextColumn = $this->getFirstLowestLevelColumnByColumn($nextColumnCandidate);
		return $nextColumn;
	}

	/**
	 * Gets the siblings for the given column
	 *
	 * @param Column $column
	 * @return \Doctrine\Common\Collections\Collection
	 */
	protected function getSiblings(Column $column){
		if($column->getParentColumn()){
			return $column->getParentColumn()->getSubColumns();
		}else{
			return $column->getBoard()->getColumns();
		}
	}

	/**
	 * Gets the relative width for the given column by comparions to it's siblings
	 *
	 * @param Column $column
	 * @return float
	 */
	public function getColumnWidth(Column $column){
		return $this->getQuotient($this->getSiblings($column)->count());
	}

	/**
	 * not sure why I implemented this method a second time(start)
	 */

	/**
	 * Removes the given column with all subColumns recursively and
	 * moves tickets to the parent or previous column
	 *
	 * @param Column $column
	 */
	public function removeColumn(Column $column){
		// iterate over subColumns
		foreach($column->getSubColumns() as $subColumn){
			// recursive call
			$this->deleteColumn($subColumn);
		}
		$this->removeTicketsFromColumn($column);
		// if there is a parent column
		if($column->getParentColumn()){
			$parentColumn = $column->getParentColumn();
			$parentColumn->removeSubColumn($column);
			$this->columnRepository->update($parentColumn);
		}else{
			$board = $column->getBoard();
			$board->removeColumn($column);
			$this->boardRepository->update($board);
		}
		$this->columnRepository->remove($column);
	}

	/**
	 * Removes tickets from the given column to a parent or previous column
	 *
	 * @param Column $column
	 */
	protected  function removeTicketsFromColumn(Column $column){
		// iterate over tickets
		foreach($column->getTickets() as $ticket){
			// try to move ticket to parent column
			if(!$this->ticketService->moveTicketToParentColumn($ticket)){
				// try to move ticket to previous column
				$this->ticketService->moveTicketToPreviousColumn($ticket);
			}
		}
	}

	/**
	 * not sure why I implemented this method a second time(end)
	 */

}
?>