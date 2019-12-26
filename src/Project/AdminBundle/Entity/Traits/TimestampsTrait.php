<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2019-03-26
 * Time: 12:04
 */

namespace Project\AdminBundle\Entity\Traits;


trait TimestampsTrait
{

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateTimestamps(){

        $now = new \DateTime();
        if($this->getCreatedAt() == null){
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
    }

}
