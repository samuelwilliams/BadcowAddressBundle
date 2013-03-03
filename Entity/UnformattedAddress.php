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
final class UnformattedAddress extends BaseAddress
{
    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $fullAddress;

    /**
     * @param string $fullAddress
     */
    public function setFullAddress($fullAddress)
    {
        $this->fullAddress = $fullAddress;
    }

    /**
     * @return string
     */
    public function getFullAddress()
    {
        return $this->fullAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $string = $this->fullAddress;
        $string .= isset($this->country) ? sprintf("\n%s", $this->country) : '';

        return $string;
    }
}
