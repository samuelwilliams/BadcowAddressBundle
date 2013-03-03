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
final class SemiFormattedAddress extends BaseAddress
{
     /**
      * @var string
      *
      * @ORM\Column(type="text", nullable=true)
      */
     protected $address;
 
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
     * @param string $address
     * @return SemiFormattedAddress
     */
    public function setAddress($address)
    {
        $this->address = $address;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $locality
     * @return SemiFormattedAddress
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
        
        return $this;
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
     * @return SemiFormattedAddress
     */
    public function setState($state)
    {
        $this->state = $state;
        
        return $this;
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
        return sprintf("%s\n%s\n%s %s",
            $this->address,
            $this->locality,
            $this->state,
            $this->postcode
        );
    }
}