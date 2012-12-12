<?php
namespace Witte\Kanban\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use TYPO3\Flow\Mvc\Controller\ActionController;
use \Witte\Kanban\Domain\Model\Board;
use \Witte\Kanban\Domain\Model\SuperiorColumn;
use \Witte\Kanban\Domain\Model\Column;
use \Witte\Kanban\Domain\Model\Ticket;

/**
 * SuperiorColumn controller for the Witte.Kanban package
 *
 * @Flow\Scope("singleton")
 */
class ColumnController extends AbstractController {

	/**
	 * @param \Witte\Kanban\Domain\Model\Board $board
	 */
	public function newAction(Board $board) {
		$this->view->assign('board', $board);
	}

	/**
	 * @param \Witte\Kanban\Domain\Model\Column $newColumn
	 */
	public function createAction(Column $newColumn) {
		$newColumn->setSort($newColumn->getSort() + 1 );
		$this->columnService->addNewColumn($newColumn);
		$this->redirect('edit', 'Board', NULL, array('board' => $this->boardService->getBoardByColumn($newColumn)));
	}

	/**
	 * @param \Witte\Kanban\Domain\Model\Column $column
	 */
	public function deleteAction(Column $column){
		if($this->columnService->removeColumnWithDependencies($column)){
			$this->addFlashMessage('Removed the column ' . $column->getTitle());
			$this->redirect('edit', 'Board', NULL, array('board' => $this->boardService->getBoardByColumn($column)));
		}else{
			$this->addFlashMessage('Could not remove the column ' . $column->getTitle());
			$this->redirect('edit', 'Board', NULL, array('board' => $this->boardService->getBoardByColumn($column)));
		}
	}
}

?>