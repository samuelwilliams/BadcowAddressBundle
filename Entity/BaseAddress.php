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
use Badcow\AddressBundle\Geocode\GeocodableInterface;

/**
 * Represents an Invoice.
 *
 * @ORM\DiscriminatorColumn(name="address_type", type="string")
 * @ORM\DiscriminatorMap({
 *   "PO_BOX" = "PoBoxAddress",
 *   "STREET_ADDRESS" = "StreetAddress",
 *   "UNFORMATTED_ADDRESS" = "UnformattedAddress",
 *   "SEMIFORMATTED_ADDRESS" = "SemiFormattedAddress",
 * })
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Table(name="badcow_address")
 */
abstract class BaseAddress implements AddressInterface, GeocodableInterface
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $country;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    protected $postcode;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected $latitude;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected $longitude;

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * {@inheritdoc}
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }
}