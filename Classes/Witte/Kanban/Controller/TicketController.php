<?php
namespace Witte\Kanban\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 * Copyright (C) 2012 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

use TYPO3\Flow\Annotations as Flow;

use TYPO3\Flow\Mvc\Controller\ActionController;
use \Witte\Kanban\Domain\Model\Board;
use \Witte\Kanban\Domain\Model\Ticket;

/**
 * Ticket controller for the Witte.Kanban package
 *
 * @Flow\Scope("singleton")
 */
class TicketController extends AbstractController {

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
	 * @param \Witte\Kanban\Domain\Model\Board $board
	 */
	public function newAction(Board $board) {
		$this->view->assign('board', $board);
		//$this->view->assign('newTicket', new Ticket());
	}

	public function showAction(Ticket $ticket){
		$this->view->assign('ticket', $ticket);
		$this->view->assign('board', $this->boardService->getBoardByTicket($ticket));
	}

	public function editAction(Ticket $ticket){
		$this->view->assign('ticket', $ticket);
		$this->view->assign('board', $this->boardService->getBoardByTicket($ticket));
	}

	public function updateAction(Ticket $ticket){
		$this->ticketRepository->update($ticket);
		$this->redirect('show', 'Board', NULL, array('board' => $this->boardService->getBoardByTicket($ticket)));
	}

	public function deleteAction(Ticket $ticket){
		$ticket->getSlot()->removeTicket($ticket);
		$this->ticketRepository->remove($ticket);
		$this->redirect('show', 'Board', NULL, array('board' => $this->boardService->getBoardByTicket($ticket)));
	}

	public function moveToNextColumnAction(Ticket $ticket){
		$this->ticketService->moveTicketToNextColumn($ticket);
		$this->redirect('show', 'Board', NULL, array('board' => $this->boardService->getBoardByTicket($ticket)));
	}

	public function moveToPreviousColumnAction(Ticket $ticket){
		$this->ticketService->moveTicketToPreviousColumn($ticket);
		$this->redirect('show', 'Board', NULL, array('board' => $this->boardService->getBoardByTicket($ticket)));
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