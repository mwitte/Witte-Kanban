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

/**
 * Backend controller for the Witte.Kanban package
 *
 * @Flow\Scope("singleton")
 */
class BoardController extends AbstractController {

	/**
	 * Shows a list of boards
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('boards', $this->boardRepository->findAll());
	}

	/**
	 * Shows a single board object
	 *
	 * @param \Witte\Kanban\Domain\Model\Board $board The board to show
	 * @return void
	 */
	public function showAction(Board $board) {
		$this->view->assign('board', $board);
	}

	/**
	 * Shows a form for creating a new board object
	 *
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * Adds the given new board object to the board repository
	 *
	 * @param \Witte\Kanban\Domain\Model\Board $newBoard A new board to add
	 * @return void
	 */
	public function createAction(Board $newBoard) {
		$this->boardService->createBoardWithDependencies($newBoard);

		$this->addFlashMessage('Created the new board ' . $newBoard->getTitle());
		$this->redirect('index');
	}

	/**
	 * Shows a form for editing an existing board object
	 *
	 * @param \Witte\Kanban\Domain\Model\Board $board The board to edit
	 * @return void
	 */
	public function editAction(Board $board) {
		$this->view->assign('board', $board);
	}

	/**
	 * Updates the given board object
	 *
	 * @param \Witte\Kanban\Domain\Model\Board $board The board to update
	 * @return void
	 */
	public function updateAction(Board $board) {
		$this->boardRepository->update($board);
		$this->addFlashMessage('Updated the board.');
		$this->redirect('show', 'Board', NULL, array('board' => $board));
	}

	/**
	 * Removes the given board object from the board repository
	 *
	 * @param \Witte\Kanban\Domain\Model\Board $board The board to delete
	 * @return void
	 */
	public function deleteAction(Board $board) {
		$this->boardRepository->remove($board);
		$this->addFlashMessage('Deleted a board.');
		$this->redirect('index');
	}
}

?>