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
use \Witte\Kanban\Domain\Model\Ticket;

/**
 * SuperiorColumn controller for the Witte.Kanban package
 *
 * @Flow\Scope("singleton")
 */
class SuperiorColumnController extends AbstractController {

	/**
	 * @param \Witte\Kanban\Domain\Model\Board $board
	 */
	public function newAction(Board $board) {
		$this->view->assign('board', $board);
		//$this->view->assign('newTicket', new Ticket());
	}

	/**
	 * @param \Witte\Kanban\Domain\Model\Board $board
	 * @param \Witte\Kanban\Domain\Model\SuperiorColumn $newSuperiorColumn
	 */
	public function createAction(Board $board, SuperiorColumn $newSuperiorColumn) {

		if($this->superiorColumnService->addNewSuperiorColumnToBoard($newSuperiorColumn, $board)){
			$this->addFlashMessage('Created the new column ' . $newSuperiorColumn->getTitle());
			$this->redirect('edit', 'Board', NULL, array('board' => $board));
		}else{
			$this->addFlashMessage('There are already too much columns!');
			$this->redirect('edit', 'Board', NULL, array('board' => $board));
		}
	}

	/**
	 * @param \Witte\Kanban\Domain\Model\Board $board
	 * @param \Witte\Kanban\Domain\Model\SuperiorColumn $superiorColumn
	 */
	public function deleteAction(Board $board, SuperiorColumn $superiorColumn){
		if($this->superiorColumnService->removeSuperiorColumnDependencies($superiorColumn)){
			$this->addFlashMessage('Removed the column ' . $superiorColumn->getTitle());
			$this->redirect('edit', 'Board', NULL, array('board' => $board));
		}else{
			$this->addFlashMessage('Could not remove the column ' . $superiorColumn->getTitle());
			$this->redirect('edit', 'Board', NULL, array('board' => $board));
		}
	}
}

?>