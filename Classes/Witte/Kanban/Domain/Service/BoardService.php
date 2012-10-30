<?php
namespace Witte\Kanban\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use \Witte\Kanban\Domain\Model\Board;
use \Witte\Kanban\Domain\Model\SubColumn;
use \Witte\Kanban\Domain\Model\SuperiorColumn;
use \Witte\Kanban\Domain\Model\Ticket;
use \Witte\Kanban\Domain\Service\AbstractService;

/**
 * Service
 *
 * @Flow\Scope("singleton")
 */
class BoardService extends AbstractService {

	/**
	 * Creates a new default board
	 *
	 * @param \Witte\Kanban\Domain\Model\Board $board
	 */
	public function createBoardWithDependencies(Board $board){

		$superiorColumnService = new SuperiorColumnService();

		/**
		 * setup the default columns
		 */
		$backlog = new SuperiorColumn();
		$backlog->setTitle('Backlog');
		$backlog->setSort(0);
		$backlog->setBoard($board);
		$board->addSuperiorColumn($backlog);
		$superiorColumnService->createSuperiorColumnDependencies($backlog);


		$onGoing = new SuperiorColumn();
		$onGoing->setTitle('On going');
		$onGoing->setSort(1);
		$onGoing->setBoard($board);
		$board->addSuperiorColumn($onGoing);
		$superiorColumnService->createSuperiorColumnDependencies($onGoing);


		$done = new SuperiorColumn();
		$done->setTitle('Done');
		$done->setSort(9999);
		$done->setBoard($board);
		$board->addSuperiorColumn($done);
		$superiorColumnService->createSuperiorColumnDependencies($done);


		$ticket = new Ticket();
		$ticket->setTitle('New Kanban board');
		$ticket->setDescription('Setup a new Kanban board');
		$ticket->setMoved(new \DateTime());
		$ticket->setSubColumn($done);
		/* @var SubColumn $doneSubColumn */
		/*
		$doneSubColumn = $done->getSubColumns()->first();
		$doneSubColumn->addTicket($ticket);
		$this->subColumnRepository->update($doneSubColumn);
		$this->ticketRepository->add($ticket);
		*/


		$this->boardRepository->add($board);
	}
}
?>