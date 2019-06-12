<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-06-12 12:30:38 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-06-12 12:46:26
 */

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Configuration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Manager\ConfigurationManager;

class ConfigurationDefaultFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $configuration = new Configuration();
        $configuration->setKey('taxeRegional');
        $configuration->setValue('DC,DCA');
        $manager->persist($configuration);
        $manager->flush();
    }
}