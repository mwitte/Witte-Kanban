<?php
namespace Witte\Kanban\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Project
 *
 * @Flow\Entity
 */
class Project {

	/**
	 * The title
	 * @var string
	 */
	protected $title;

	/**
	 * The description
	 * @var string
	 */
	protected $description;

    /**
     * The creation date
     * @var \DateTime
     */
    protected $created;


    public function __construct(){
        $this->created = new \DateTime();
    }
	/**
	 * Get the Project's title
	 *
	 * @return string The Project's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this Project's title
	 *
	 * @param string $title The Project's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get the Project's description
	 *
	 * @return string The Project's description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets this Project's description
	 *
	 * @param string $description The Project's description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
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

}
?>