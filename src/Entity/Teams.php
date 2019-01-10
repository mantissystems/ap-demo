<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teams
 *
 * @ORM\Table(name="teams")
 * @ORM\Entity
 */
class Teams
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
     * @ORM\Column(name="home", type="string", length=255, nullable=true)
     */
    public $home;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="officials", type="boolean", nullable=true)
     */
    public $officials;

    /**
     * @var string|null
     *
     * @ORM\Column(name="poule", type="string", length=50, nullable=true)
     */
    public $poule;

    /**
     * @var string|null
     *
     * @ORM\Column(name="donotuse", type="string", length=50, nullable=true)
     */
    public $donotuse;

    /**
     * @var int|null
     *
     * @ORM\Column(name="members", type="integer", nullable=true)
     */
    public $members;

    /**
     * @var int|null
     *
     * @ORM\Column(name="schedule", type="integer", nullable=true)
     */
    public $schedule;

    /**
     * @var string|null
     *
     * @ORM\Column(name="history", type="string", length=50, nullable=true)
     */
    public $history;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    public $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Competition", type="string", length=50, nullable=true)
     */
    public $competition;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Performed", type="integer", nullable=true)
     */
    public $performed;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Wins", type="integer", nullable=true)
     */
    public $wins;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Equals", type="integer", nullable=true)
     */
    public $equals;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Lost", type="integer", nullable=true)
     */
    public $lost;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Ahead", type="integer", nullable=true)
     */
    public $ahead;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Against", type="integer", nullable=true)
     */
    public $against;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Timetable", type="string", length=50, nullable=true)
     */
    public $timetable;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Point", type="string", length=50, nullable=true)
     */
    public $point;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Seq", type="string", length=50, nullable=true)
     */
    public $seq;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nr", type="string", length=50, nullable=true)
     */
    public $nr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Payed", type="decimal", precision=19, scale=4, nullable=true)
     */
    public $payed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHome(): ?string
    {
        return $this->home;
    }

    public function setHome(?string $home): self
    {
        $this->home = $home;

        return $this;
    }

    public function getOfficials(): ?bool
    {
        return $this->officials;
    }

    public function setOfficials(?bool $officials): self
    {
        $this->officials = $officials;

        return $this;
    }

    public function getPoule(): ?string
    {
        return $this->poule;
    }

    public function setPoule(?string $poule): self
    {
        $this->poule = $poule;

        return $this;
    }

    public function getDonotuse(): ?string
    {
        return $this->donotuse;
    }

    public function setDonotuse(?string $donotuse): self
    {
        $this->donotuse = $donotuse;

        return $this;
    }

    public function getMembers(): ?int
    {
        return $this->members;
    }

    public function setMembers(?int $members): self
    {
        $this->members = $members;

        return $this;
    }

    public function getSchedule(): ?int
    {
        return $this->schedule;
    }

    public function setSchedule(?int $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getHistory(): ?string
    {
        return $this->history;
    }

    public function setHistory(?string $history): self
    {
        $this->history = $history;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCompetition(): ?string
    {
        return $this->competition;
    }

    public function setCompetition(?string $competition): self
    {
        $this->competition = $competition;

        return $this;
    }

    public function getPerformed(): ?int
    {
        return $this->performed;
    }

    public function setPerformed(?int $performed): self
    {
        $this->performed = $performed;

        return $this;
    }

    public function getWins(): ?int
    {
        return $this->wins;
    }

    public function setWins(?int $wins): self
    {
        $this->wins = $wins;

        return $this;
    }

    public function getEquals(): ?int
    {
        return $this->equals;
    }

    public function setEquals(?int $equals): self
    {
        $this->equals = $equals;

        return $this;
    }

    public function getLost(): ?int
    {
        return $this->lost;
    }

    public function setLost(?int $lost): self
    {
        $this->lost = $lost;

        return $this;
    }

    public function getAhead(): ?int
    {
        return $this->ahead;
    }

    public function setAhead(?int $ahead): self
    {
        $this->ahead = $ahead;

        return $this;
    }

    public function getAgainst(): ?int
    {
        return $this->against;
    }

    public function setAgainst(?int $against): self
    {
        $this->against = $against;

        return $this;
    }

    public function getTimetable(): ?string
    {
        return $this->timetable;
    }

    public function setTimetable(?string $timetable): self
    {
        $this->timetable = $timetable;

        return $this;
    }

    public function getPoint(): ?string
    {
        return $this->point;
    }

    public function setPoint(?string $point): self
    {
        $this->point = $point;

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

    public function getNr(): ?string
    {
        return $this->nr;
    }

    public function setNr(?string $nr): self
    {
        $this->nr = $nr;

        return $this;
    }

    public function getPayed()
    {
        return $this->payed;
    }

    public function setPayed($payed): self
    {
        $this->payed = $payed;

        return $this;
    }


}
