<?php
/*
 * This file is part of the Badcow Address Bundle.
 *
 * (c) Samuel Williams <sam@badcow.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Badcow\AddressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
final class StreetAddress extends BaseAddress
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    protected $unitNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    protected $streetNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $street;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    protected $streetType;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $locality;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $state;

    /**
     * @param string $locality
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
    }

    /**
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
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
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $streetNumber
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
    }

    /**
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * @param string $streetType
     */
    public function setStreetType($streetType)
    {
        $this->streetType = $streetType;
    }

    /**
     * @return string
     */
    public function getStreetType()
    {
        return $this->streetType;
    }

    /**
     * @param string $unitNumber
     */
    public function setUnitNumber($unitNumber)
    {
        $this->unitNumber = $unitNumber;
    }

    /**
     * @return string
     */
    public function getUnitNumber()
    {
        return $this->unitNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $string  = '';
        $string .= isset($this->unitNumber) ? sprintf("Unit %s\n", $this->unitNumber) : '';
        $string .= sprintf("%s %s %s\n", $this->streetNumber, $this->getStreet(), $this->streetType);
        $string .= sprintf("%s %s %s", $this->locality, $this->state, $this->postcode);
        $string .= isset($this->country) ? sprintf("\n%s", $this->country) : '';

        return $string;
    }
}
