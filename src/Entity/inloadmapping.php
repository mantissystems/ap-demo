<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inloadfiles
 *
 * @ORM\Table(name="inloadmapping")
 * @ORM\Entity
 */
class inloadmapping
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    
public $id;    	

    /**
     * @var string
     *
     * @ORM\Column(name="stream_id", type="string", nullable=true)
     */

    public $stream_id;    	
            /**
     * @var string
     *
     * @ORM\Column(name="table_right", type="string", nullable=true)
     */
    
    public $table_right;    	
    /**
     * @var string
     *

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", nullable=true)
     */
public $source;    	
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
public $status;    
    /**
     * @var string
     *
     * @ORM\Column(name="source_column", type="string", nullable=true)
     */
public $source_column; 
    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", nullable=true)
     */
public $destination;

public function getId(): ?int
{
    return $this->id;
}

public function getStreamId(): ?string
{
    return $this->stream_id;
}

public function setStreamId(?string $stream_id): self
{
    $this->stream_id = $stream_id;

    return $this;
}

public function getTableRight(): ?string
{
    return $this->table_right;
}

public function setTableRight(?string $table_right): self
{
    $this->table_right = $table_right;

    return $this;
}

public function getSource(): ?string
{
    return $this->source;
}

public function setSource(?string $source): self
{
    $this->source = $source;

    return $this;
}

public function getStatus(): ?string
{
    return $this->status;
}

public function setStatus(?string $status): self
{
    $this->status = $status;

    return $this;
}

public function getSourceColumn(): ?string
{
    return $this->source_column;
}

public function setSourceColumn(?string $source_column): self
{
    $this->source_column = $source_column;

    return $this;
}

public function getDestination(): ?string
{
    return $this->destination;
}

public function setDestination(?string $destination): self
{
    $this->destination = $destination;

    return $this;
}    

public function getnoerror()
{
    $qb = $this->createQueryBuilder('u');
    $qb->where('u.source != :identifier')
       ->setParameter('identifier', 1);

    return $qb->getQuery()
          ->getResult();
}

}
