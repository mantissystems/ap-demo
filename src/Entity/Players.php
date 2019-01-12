<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Players
 *
 * @ORM\Table(name="players")
 * @ORM\Entity
 */
class Players
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
     * @ORM\Column(name="tpr", type="string", length=255, nullable=true)
     */
    public $tpr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="team", type="string", length=255, nullable=true)
     */
    public $team;

    /**
     * @var string|null
     *
     * @ORM\Column(name="playername", type="string", length=255, nullable=true)
     */
    public $playername;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gamerating", type="string", length=255, nullable=true)
     */
    public $gamerating;

    /**
     * @var string|null
     *
     * @ORM\Column(name="points", type="string", length=255, nullable=true)
     */
    public $points;

    /**
     * @var string|null
     *
     * @ORM\Column(name="restistance", type="string", length=255, nullable=true)
     */
    public $restistance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="seq", type="string", length=255, nullable=true)
     */
    public $seq;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lottery", type="string", length=255, nullable=true)
     */
    public $lottery;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tpoints", type="string", length=255, nullable=true)
     */
    public $tpoints;

    /**
     * @var string|null
     *
     * @ORM\Column(name="round", type="string", length=255, nullable=true)
     */
    public $round;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTpr(): ?string
    {
        return $this->tpr;
    }

    public function setTpr(?string $tpr): self
    {
        $this->tpr = $tpr;

        return $this;
    }

    public function getTeam(): ?string
    {
        return $this->team;
    }

    public function setTeam(?string $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getPlayername(): ?string
    {
        return $this->playername;
    }

    public function setPlayername(?string $playername): self
    {
        $this->playername = $playername;

        return $this;
    }

    public function getGamerating(): ?string
    {
        return $this->gamerating;
    }

    public function setGamerating(?string $gamerating): self
    {
        $this->gamerating = $gamerating;

        return $this;
    }

    public function getPoints(): ?string
    {
        return $this->points;
    }

    public function setPoints(?string $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getRestistance(): ?string
    {
        return $this->restistance;
    }

    public function setRestistance(?string $restistance): self
    {
        $this->restistance = $restistance;

        return $this;
    }

    public function getSeq(): ?string
    {
        return $this->seq;
    }

    public function setSeq(?string $seq): self
    {
        $this->seq = $seq;

        return $this;
    }

    public function getLottery(): ?string
    {
        return $this->lottery;
    }

    public function setLottery(?string $lottery): self
    {
        $this->lottery = $lottery;

        return $this;
    }

    public function getTpoints(): ?string
    {
        return $this->tpoints;
    }

    public function setTpoints(?string $tpoints): self
    {
        $this->tpoints = $tpoints;

        return $this;
    }

    public function getRound(): ?string
    {
        return $this->round;
    }

    public function setRound(?string $round): self
    {
        $this->round = $round;

        return $this;
    }


} 