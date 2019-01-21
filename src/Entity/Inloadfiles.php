<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inloadfiles
 *
 * @ORM\Table(name="inloadfiles")
 * @ORM\Entity
 */
class Inloadfiles
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
     * @var string|null
     *
     * @ORM\Column(name="mapid", type="string", length=255, nullable=true)
     */
    public $mapid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sourcefile", type="string", length=255, nullable=true)
     */
    public $sourcefile;

    /**
     * @var string|null
     *
     * @ORM\Column(name="destination", type="string", length=255, nullable=true)
     */
    public $destination;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sourcecolumn", type="string", length=255, nullable=true)
     */
    public $sourcecolumn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="destinationfield", type="string", length=255, nullable=true)
     */
    public $destinationfield;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="loadedat", type="datetime", nullable=true)
     */
    public $loadedat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="datalines", type="string", length=255, nullable=true)
     */
    public $datalines;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="randomizedat", type="datetime", nullable=true)
     */
    public $randomizedat;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="randomizeable", type="boolean", nullable=true)
     */
    public $randomizeable;
/**
     * @var bool|null
     *
     * @ORM\Column(name="loadable", type="boolean", nullable=true)
     */
    public $loadable;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMapid(): ?string
    {
        return $this->mapid;
    }

    public function setMapid(?string $mapid): self
    {
        $this->mapid = $mapid;

        return $this;
    }

    public function getSourcefile(): ?string
    {
        return $this->sourcefile;
    }

    public function setSourcefile(?string $sourcefile): self
    {
        $this->sourcefile = $sourcefile;

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

    public function getSourcecolumn(): ?string
    {
        return $this->sourcecolumn;
    }

    public function setSourcecolumn(?string $sourcecolumn): self
    {
        $this->sourcecolumn = $sourcecolumn;

        return $this;
    }

    public function getDestinationfield(): ?string
    {
        return $this->destinationfield;
    }

    public function setDestinationfield(?string $destinationfield): self
    {
        $this->destinationfield = $destinationfield;

        return $this;
    }

    public function getLoadedat(): ?\DateTimeInterface
    {
        return $this->loadedat;
    }

    public function setLoadedat(?\DateTimeInterface $loadedat): self
    {
        $this->loadedat = $loadedat;

        return $this;
    }

    public function getDatalines(): ?string
    {
        return $this->datalines;
    }

    public function setDatalines(?string $datalines): self
    {
        $this->datalines = $datalines;

        return $this;
    }

    public function getRandomizedat(): ?\DateTimeInterface
    {
        return $this->randomizedat;
    }

    public function setRandomizedat(?\DateTimeInterface $randomizedat): self
    {
        $this->randomizedat = $randomizedat;

        return $this;
    }

    public function getRandomizeable(): ?bool
    {
        return $this->randomizeable;
    }

    public function setRandomizeable(?bool $randomizeable): self
    {
        $this->randomizeable = $randomizeable;

        return $this;
    }

    public function getLoadable(): ?bool
    {
        return $this->loadable;
    }

    public function setLoadable(?bool $loadable): self
    {
        $this->loadable = $loadable;

        return $this;
    }


}
