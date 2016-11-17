<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of LoadPostData
 *
 * @author dominik
 */
class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $faker = \Faker\Factory::create();
        
        for ( $i=1; $i<=100; $i++) {
            
            $post = new \AppBundle\Entity\Post();
            $post->setTitle($faker->sentence(5));
            $post->setLead($faker->text(300));
            $post->setContent($faker->text(700));
            $post->setCreatedAt($faker->dateTimeThisDecade);
            
            $manager->persist($post);
        }
        
        $manager->flush();
        
    }


}
