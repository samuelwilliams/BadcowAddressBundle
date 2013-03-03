<?php

namespace Badcow\AddressBundle\Command;

use Badcow\AddressBundle\Entity\BaseAddress;
use Geocoder\Exception\NoResultException;
use Geocoder\Result\Geocoded;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GeocodeCommand extends ContainerAwareCommand
{
    /**
     * Limits the rate of queries
     */
    const QUERY_SLEEP_TIME = 100;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('badcow:address:geocode');
        $this->setDescription('Geocode all addresses without latitude and longitude');
    }

    /**
     * {@inheritdoc}
     */
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
            try {
                $geocoded = $geocoder->geocode((string) $address);
                $this->updateAddress($address, $geocoded);
            } catch (NoResultException $e) {
                $output->writeln(sprintf('<error>Unable to geocode address: %s</error>', $address));
            }

            usleep(self::QUERY_SLEEP_TIME);
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
                ->getRepository('BadcowAddressBundle:BaseAddress')
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
     * @param BaseAddress $address
     * @param Geocoded $geocoded
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