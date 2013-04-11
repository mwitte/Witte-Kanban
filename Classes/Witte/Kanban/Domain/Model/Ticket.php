<?php
namespace Witte\Kanban\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 * Copyright (C) 2012 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Ticket
 *
 * @Flow\Entity
 */
class Ticket {

	/**
	 * The title
	 * @var string
	 */
	protected $title;

	/**
	 * The description
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $description;

	/**
	 * The version
	 * @var string
	 */
	protected $version;

	/**
	 * The created
	 * @var \DateTime
	 */
	protected $created;

	/**
	 * The started
	 * @var \DateTime
	 */
	protected $started;

	/**
	 * The moved
	 * @var \DateTime
	 */
	protected $moved;

	/**
	 * @var \Witte\Kanban\Domain\Model\Column
	 * @ORM\ManyToOne(inversedBy="tickets")
	 */
	protected $slot;

	/**
	 * @var \Witte\Kanban\Domain\Model\Board
	 * @ORM\ManyToOne(inversedBy="ticketArchive")
	 */
	protected $board;

	/**
	 * @var \TYPO3\Flow\Resource\Resource
	 * @ORM\ManyToOne
	 */
	protected $file;

	public function __construct(){
		$this->created = new \DateTime();
		$this->moved = new \DateTime();
		$this->started = new \DateTime();
		$this->version = '';
	}

	/**
	 * @param \DateTime $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param \DateTime $moved
	 */
	public function setMoved($moved)
	{
		$this->moved = $moved;
	}

	/**
	 * @return \DateTime
	 */
	public function getMoved()
	{
		return $this->moved;
	}

	/**
	 * @param \DateTime $started
	 */
	public function setStarted($started)
	{
		$this->started = $started;
	}

	/**
	 * @return \DateTime
	 */
	public function getStarted()
	{
		return $this->started;
	}

	/**
	 * @param string $version
	 */
	public function setVersion($version)
	{
		$this->version = $version;
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return $this->version;
	}

	/**
	 * @param \Witte\Kanban\Domain\Model\Board $board
	 */
	public function setBoard($board)
	{
		$this->board = $board;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Board
	 */
	public function getBoard()
	{
		return $this->board;
	}

	/**
	 * @param \Witte\Kanban\Domain\Model\Column $column
	 */
	public function setSlot($slot)
	{
		$this->slot = $slot;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Column
	 */
	public function getSlot()
	{
		return $this->slot;
	}

	public function getColumn(){
		return $this->slot;
	}

	public function setColumn($column){
		$this->slot = $column;
	}

	/**
	 * @param \TYPO3\Flow\Resource\Resource $file
	 * @return void
	 */
	public function setFile(\TYPO3\Flow\Resource\Resource $file) {
		$this->file = $file;
	}

	/**
	 * @return \TYPO3\Flow\Resource\Resource
	 */
	public function getFile() {
		return $this->file;
	}
}
?>