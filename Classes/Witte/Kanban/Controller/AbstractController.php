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
 * Base controller for the Witte.Kanban package
 *
 * @Flow\Scope("singleton")
 */
abstract class AbstractController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Repository\BoardRepository
	 */
	protected $boardRepository;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Repository\SuperiorColumnRepository
	 */
	protected $superiorColumnRepository;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Repository\SubColumnRepository
	 */
	protected $subColumnRepository;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Repository\TicketRepository
	 */
	protected $ticketRepository;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\BoardService
	 */
	protected $boardService;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\SuperiorColumnService
	 */
	protected $superiorColumnService;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\SubColumnService
	 */
	protected $subColumnService;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\TicketService
	 */
	protected $ticketService;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * Inject the settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	protected function addNeededObjectsToView(){
		$this->view->assign('boards', $this->boardRepository->findAll());
	}
}

?>