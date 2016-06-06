<?php

namespace Lynda\MagazineBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Lynda\MagazineBundle\Entity\Issue;

class LoadIssueData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $issue1 = new Issue();
        $issue1->setNumber(1);
        $issue1->setDatePublication(new \DateTime('2015-01-01'));
        $issue1->setCover('web_developer_avatar.png');
        $issue1->setPublication($this->getReference('pub1'));


        $issue2 = new Issue();
        $issue2->setNumber(2);
        $issue2->setDatePublication(new \DateTime('2015-03-01'));
        $issue2->setCover('mortal-kombat.jpg');
        $issue2->setPublication($this->getReference('pub2'));

        $manager->persist($issue1);
        $manager->persist($issue2);
        $manager->flush();
    }

    public function getOrder()
    {   
       return 2; 
    }      
}