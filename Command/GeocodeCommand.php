<?php

namespace Badcow\AddressBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Badcow\AddressBundle\Entity\BaseAddress;
use Geocoder\Result\Geocoded;

class GeocodeCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this->setName('badcow_address:gecode');
        $this->setDescription('Geocode all addresses without latitude and longitude');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $geocoder = $this->getGeocoder();
        $addresses = $this->getAddresses();

        if (empty($addresses)) {
            $output->writeln("There is nothing to geocode.");
        }

        /** @var BaseAddress $address */
        foreach ($addresses as $address) {
            $output->writeln(sprintf('Geocoding "%s"', $address));
            $geocoded = $geocoder->geocode((string) $address);
            $this->updateAddress($address, $geocoded);
            usleep(100); //Rate limit the queries
        }
    }

    /**
     * Get addresses with null latitudes/longitudes
     *
     * @return array
     */
    private function getAddresses()
    {
        $doctrine = $this->getDoctrine();

        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $doctrine
                ->getRepository('BadcowAddressBundle:StreetAddress')
                ->createQueryBuilder('a');

        $qb->add('where', $qb->expr()->orX(
            $qb->expr()->isNull('a.latitude'),
            $qb->expr()->isNull('a.longitude')
        ));

        return $qb->getQuery()->getResult();
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    public function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    /**
     * @return \Geocoder\Geocoder
     */
    private function getGeocoder()
    {
        return $this->getContainer()->get('bazinga_geocoder.geocoder');
    }

    /**
     * @param \Badcow\AddressBundle\Entity\BaseAddress $address
     * @param \Geocoder\Result\Geocoded $geocoded
     */
    private function updateAddress(BaseAddress $address, Geocoded $geocoded)
    {
        $address->setLatitude($geocoded->getLatitude());
        $address->setLongitude($geocoded->getLongitude());

        $em = $this->getDoctrine()->getManager();
        $em->persist($address);
        $em->flush();
    }
}

