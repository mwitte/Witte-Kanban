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
use \Witte\Kanban\Domain\Model\SubColumn;
use \Witte\Kanban\Domain\Service\AbstractService;

/**
 * Service
 *
 * @Flow\Scope("singleton")
 */
class TicketService extends AbstractService {

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\SubColumnService
	 */
	protected $subColumnService;

	public function moveTicketToNextSubColumn(Ticket $ticket){
		$nextSubColumn = $this->subColumnService->getNextSubColumn($ticket->getSubColumn());
		if($nextSubColumn){
			$this->moveTicketToSubColumn($ticket, $nextSubColumn);
		}
	}

	public function moveTicketToPreviousSubColumn(Ticket $ticket){
		$previousSubColumn = $this->subColumnService->getPreviousSubColumn($ticket->getSubColumn());
		if($previousSubColumn){
			$this->moveTicketToSubColumn($ticket, $previousSubColumn);
		}
	}

	public function moveTicketToSubColumn(Ticket $ticket, SubColumn $subColumn){

		// ticket is moving, so set current date for moved
		$ticket->setMoved(new \DateTime());

		// remove ticket from old column
		$oldSubColumn = $ticket->getSubColumn();
		$oldSubColumn->removeTicket($ticket);
		$this->subColumnRepository->update($oldSubColumn);

		// if old place was first column set the started date
		if($oldSubColumn->getSuperiorColumn()->getIsFirst()){
			$ticket->setStarted(new \DateTime());
		}


		$ticket->setSubColumn($subColumn);
		$subColumn->addTicket($ticket);

		$this->subColumnRepository->update($subColumn);
		$this->ticketRepository->update($ticket);
	}

	public function createTicketInSubColumn(Ticket $ticket, SubColumn $subColumn){
		$ticket->setSubColumn($subColumn);
		$subColumn->addTicket($ticket);

		$this->ticketRepository->add($ticket);
		$this->subColumnRepository->update($subColumn);
	}

	public function createTicketInBoard(Ticket $ticket, Board $board){
		$subColumn = $board->getSuperiorColumns()->first()->getSubColumns()->first();
		$this->createTicketInSubColumn($ticket, $subColumn);
	}
}
?>