<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Faker\Factory;
use App\Enum\Membership\Gender;
use App\Entity\Membership\Membership;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MembershipFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $this->createMembership(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameFemale(),
            birthdate: new \DateTimeImmutable('-20 years'),
            gender: Gender::Female,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            tutorLastname: $faker->lastName(),
            tutorFirstname: $faker->firstName(),
            tutorPhone: $faker->numerify('0#########'),
            tutorEmail: $faker->unique()->safeEmail(),
            tutorAddress: $faker->buildingNumber() . ' ' . $faker->streetName(),
            tutorPostalcode: $faker->postcode(),
            tutorCity: $faker->city(),
            profileImage: 'female_default_profile.png',
        );

        $this->createMembership(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameMale(),
            birthdate: new \DateTimeImmutable('-25 years'),
            gender: Gender::Male,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            profileImage: 'male_default_profile.png',
        );

        $this->createMembership(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstName(),
            birthdate: new \DateTimeImmutable('-15 years'),
            gender: Gender::Other,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            tutorLastname: $faker->lastName(),
            tutorFirstname: $faker->firstName(),
            tutorPhone: $faker->numerify('0#########'),
            tutorEmail: $faker->unique()->safeEmail(),
            tutorAddress: $faker->buildingNumber() . ' ' . $faker->streetName(),
            tutorPostalcode: $faker->postcode(),
            tutorCity: $faker->city(),
            profileImage: 'other_default_profile.png',
        );

        $manager->flush();
    }

    private function createMembership(
        ObjectManager $manager,
        string $lastname,
        string $firstname,
        \DateTimeImmutable $birthdate,
        Gender $gender,
        string $phone,
        string $address,
        string $postalcode,
        string $city,
        string $email,
        ?string $tutorLastname = null,
        ?string $tutorFirstname = null,
        ?string $tutorPhone = null,
        ?string $tutorEmail = null,
        ?string $tutorAddress = null,
        ?string $tutorPostalcode = null,
        ?string $tutorCity = null,
        ?string $profileImage = null,
    ): void
    {
        $membership = Membership::create(
            lastname: $lastname,
            firstname: $firstname,
            birthdate: $birthdate,
            gender: $gender,
            phone: $phone,
            address: $address,
            postalcode: $postalcode,
            city: $city,
            email: $email,
            tutorLastname: $tutorLastname,
            tutorFirstname: $tutorFirstname,
            tutorPhone: $tutorPhone,
            tutorEmail: $tutorEmail,
            tutorAddress: $tutorAddress,
            tutorPostalcode: $tutorPostalcode,
            tutorCity: $tutorCity,
            profileImage: $profileImage,
        );

        $manager->persist($membership);
    }
}
