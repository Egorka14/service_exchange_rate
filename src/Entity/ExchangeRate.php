<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExchangeRateRepository")
 */
class ExchangeRate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateCurrency;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=3500, nullable=true)
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function setDateCurrency($dateCurrency): void
    {
        $this->dateCurrency = $dateCurrency;
    }

    /**
     * @return mixed
     */
    public function getDateCurrency()
    {
        return $this->dateCurrency;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return json_decode($this->content, 1);
    }

    /**
     * @param string
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
