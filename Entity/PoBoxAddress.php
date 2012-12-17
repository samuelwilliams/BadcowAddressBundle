<?php

namespace Badcow\AddressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PoBoxAddress extends BaseAddress
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16)
     */
    protected $prefix = 'PO Box';

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16)
     */
    protected $poBoxNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $poName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $state;

    /**
     * @param string $poBoxNumber
     */
    public function setPoBoxNumber($poBoxNumber)
    {
        $this->poBoxNumber = $poBoxNumber;
    }

    /**
     * @return string
     */
    public function getPoBoxNumber()
    {
        return $this->poBoxNumber;
    }

    /**
     * @param string $poName
     */
    public function setPoName($poName)
    {
        $this->poName = $poName;
    }

    /**
     * @return string
     */
    public function getPoName()
    {
        return $this->poName;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $string = sprintf("%s %s\n%s %s %s",
            $this->prefix,
            $this->poBoxNumber,
            $this->poName,
            $this->state,
            $this->postcode
        );
        $string .= isset($this->country) ? sprintf("\n%s", $this->country) : '';

        return $string;
    }
}
