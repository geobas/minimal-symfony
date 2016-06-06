<?php

namespace Lynda\MagazineBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Lynda\MagazineBundle\Entity\Publication;

class LoadPublicationData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $publication1 = new Publication();
        $publication1->setName('publication1');
        $this->addReference('pub1', $publication1);

        $publication2 = new Publication();
        $publication2->setName('publication2');
        $this->addReference('pub2', $publication2);

        $manager->persist($publication1);
        $manager->persist($publication2);
        $manager->flush();
    }

    public function getOrder()
    {
       // the order in which fixtures will be loaded
       // the lower the number, the sooner that this fixture is loaded        
       return 1; 
    }    
}