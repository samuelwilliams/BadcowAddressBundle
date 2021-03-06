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

interface AddressInterface
{
    /**
     * Full address string
     *
     * @return string
     */
    public function __toString();
}