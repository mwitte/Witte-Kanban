<?php
namespace Witte\Kanban\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use \Witte\Kanban\Domain\Model\SubColumn;

/**
 * A Column
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
	 * The created
	 * @var \DateTime
	 */
	protected $created;

	/**
	 * The moved
	 * @var \DateTime
	 */
	protected $moved;

	/**
	 * @var \Witte\Kanban\Domain\Model\SubColumn
	 * @ORM\ManyToOne(inversedBy="tickets")
	 */
	protected $subColumn;

	public function __construct(){
		$this->created = new \DateTime();
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
	 * @param SubColumn $subColumn
	 */
	public function setSubColumn($subColumn)
	{
		$this->subColumn = $subColumn;
	}

	/**
	 * @return SubColumn
	 */
	public function getSubColumn()
	{
		return $this->subColumn;
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
}
?>