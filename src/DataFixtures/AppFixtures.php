<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\AutoGlassFactory;
use App\Factory\CarDoorFactory;
use App\Factory\TyresFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create admin User
        $adminUser = new User();
        $adminUser->setEmail('admin@gmail.com');
        $adminUser->setPassword(123456);
        $adminUser->setRoles(['ROLE_ADMIN']);

        $manager->persist($adminUser);
        $manager->flush();

        // Create dummy data
        UserFactory::createOne();
        TyresFactory::createMany(50);
        CarDoorFactory::createMany(50);
        AutoGlassFactory::createMany(50);
    }
}
