<?php

namespace App\DataFixtures;

use \Faker\Factory;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Image;
use Bezhanov\Faker\Provider\Space;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{   
    private $encoder;
    protected $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create('fr_FR');
        $this->faker->addProvider(new \Bezhanov\Faker\Provider\Space($this->faker));
        $tags=[];

        for ($h = 1; $h <= 15; $h++){
            $tag = new Tag();
            $tag->setName($this->faker->unique()->word());
            $manager->persist($tag);
            $tags[$h]=$tag;
        }

        
        for ($i = 1; $i < 20; $i++){
            $user = new User();

            for ($j = 1; $j <= 5; $j++){
                $image = new Image();
                for ($k = 1; $k <= 3; $k++){
                    $image->addTag($tags[(($j - 1) * $k) + $k]);                  
                }                         
                $picture = "https://picsum.photos/id/2$j/200/300";
                $image->setName($picture);
                $image->setUser($user);
                $image->setTitle($this->faker->sentence(6,true)) ;

                $manager->persist($image);
            }
            $user->setUsername($this->faker->userName());

            $password = $this->encoder->encodePassword($user, 'pass_1234');
            $user->setPassword($password);

            $manager->persist($user);
            
        }
        $manager->flush();
    }
}
