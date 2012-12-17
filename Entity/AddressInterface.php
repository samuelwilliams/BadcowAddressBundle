<?php

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