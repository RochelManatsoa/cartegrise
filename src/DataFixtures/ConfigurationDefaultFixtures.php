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
        // 1
        $configuration1 = new Configuration();
        $configuration1->setKeyConf('sansTaxeRegional');
        $configuration1->setDC(true);
        $configuration1->setDCA(true);
        $manager->persist($configuration1);
        // 2
        $configuration2 = new Configuration();
        $configuration2->setKeyConf('taxeRegional/PuissanceFiscal');
        $configuration2->setDUP(true);
        $manager->persist($configuration2);
        // 2
        $configuration3 = new Configuration();
        $configuration3->setKeyConf('sansTaxes');
        $configuration3->setDCA(true);
        $manager->persist($configuration3);
        $manager->flush();
    }
}