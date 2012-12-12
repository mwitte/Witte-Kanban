<?php
namespace Witte\Kanban\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 * Copyright (C) 2012 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Board
 *
 * @Flow\Entity
 */
class Board {

	/**
	 * The title
	 * @var string
	 */
	protected $title;

	/**
	 * The Columns contained in this board
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\Column>
	 * @ORM\OneToMany(mappedBy="board", cascade={"remove", "persist"})
	 * @ORM\OrderBy({"sort" = "ASC"})
	 */
	protected $columns;

	/**
	 * The archived tickets contained in this board
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\Ticket>
	 * @ORM\OneToMany(mappedBy="board", cascade={"remove", "persist"})
	 * @ORM\OrderBy({"moved" = "DESC"})
	 */
	protected $ticketArchive;

	/**
	 * The created
	 * @var \DateTime
	 */
	protected $created;


	public function __construct(){
		$this->columns = new \Doctrine\Common\Collections\ArrayCollection();
		$this->ticketArchive = new \Doctrine\Common\Collections\ArrayCollection();
		$this->created = new \DateTime();
	}

	/**
	 * Get the Board's title
	 *
	 * @return string The Board's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this Board's title
	 *
	 * @param string $title The Board's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get the Board's Columns
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\Column> The Board's Columns
	 */
	public function getColumns() {
		return $this->columns;
	}

	/**
	 * Sets this Board's Columns
	 *
	 * @param \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\Column> $columns The Board's Columns
	 * @return void
	 */
	public function setColumns($columns) {
		$this->columns = $columns;
	}

	/**
	 * @param Column $column
	 */
	public function addColumn(Column $column){
		$this->columns->add($column);
	}

	/**
	 * @param Column $column
	 */
	public function removeColumn(Column $column){
		$this->columns->removeElement($column);
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
	 * @param \Doctrine\Common\Collections\Collection $ticketArchive
	 */
	public function setTicketArchive($ticketArchive)
	{
		$this->ticketArchive = $ticketArchive;
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getTicketArchive()
	{
		return $this->ticketArchive;
	}

	public function addToTicketArchive(Ticket $ticket){
		$this->ticketArchive->add($ticket);
	}

	public function removeFromTicketArchive(Ticket $ticket){
		$this->ticketArchive->removeElement($ticket);
	}

}
?>