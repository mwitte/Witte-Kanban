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
 * Ticket controller for the Witte.Kanban package
 *
 * @Flow\Scope("singleton")
 */
class TicketController extends AbstractController {

	/**
	 * @param \Witte\Kanban\Domain\Model\Board $board
	 */
	public function newAction(Board $board) {
		$this->view->assign('board', $board);
		//$this->view->assign('newTicket', new Ticket());
	}

	public function showAction(Ticket $ticket){
		$this->view->assign('ticket', $ticket);
		$this->view->assign('board', $ticket->getSubColumn()->getSuperiorColumn()->getBoard());
	}

	public function editAction(Ticket $ticket){
		$this->view->assign('ticket', $ticket);
		$this->view->assign('board', $ticket->getSubColumn()->getSuperiorColumn()->getBoard());
	}

	public function updateAction(Ticket $ticket){
		$this->ticketRepository->update($ticket);
		$this->redirect('show', 'Board', NULL, array('board' => $ticket->getSubColumn()->getSuperiorColumn()->getBoard()));
	}

	public function deleteAction(Ticket $ticket){
		$ticket->getSubColumn()->removeTicket($ticket);
		$this->ticketRepository->remove($ticket);
		$this->redirect('show', 'Board', NULL, array('board' => $ticket->getSubColumn()->getSuperiorColumn()->getBoard()));
	}

	public function moveToNextSubColumnAction(Ticket $ticket){
		$this->ticketService->moveTicketToNextSubColumn($ticket);
		$this->redirect('show', 'Board', NULL, array('board' => $ticket->getSubColumn()->getSuperiorColumn()->getBoard()));
	}

	public function moveToPreviousSubColumnAction(Ticket $ticket){
		$this->ticketService->moveTicketToPreviousSubColumn($ticket);
		$this->redirect('show', 'Board', NULL, array('board' => $ticket->getSubColumn()->getSuperiorColumn()->getBoard()));
	}

	public function archivingAction(Ticket $ticket){
		$this->ticketService->archiveTicket($ticket);
		$this->redirect('show', 'Board', NULL, array('board' => $ticket->getBoard()));
	}

	public function archiveAction(Board $board){
		$this->view->assign('board', $board);
	}

	/**
	 * @param \Witte\Kanban\Domain\Model\Board $board
	 * @param \Witte\Kanban\Domain\Model\Ticket $newTicket
	 */
	public function createAction(Board $board, Ticket $newTicket) {

		$this->ticketService->createTicketInBoard($newTicket, $board);

		$this->addFlashMessage('Created the new ticket ' . $newTicket->getTitle());
		$this->redirect('show', 'Board', NULL, array('board' => $board));

	}
}

?>