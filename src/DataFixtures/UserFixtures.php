<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Faker\Factory;
use App\Enum\Security\Role;
use App\Entity\Security\User;
use App\Enum\Membership\Gender;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Service\ProfileImage\ProfileImageService;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture
{
    public function __construct(private ProfileImageService $profileImageService)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $this->createUser(
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
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::MALE_PROFILE),
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $this->createUser(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameMale(),
            birthdate: new \DateTimeImmutable('-24 years'),
            gender: Gender::Male,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::MALE_PROFILE),
            annualMembershipFee: null,
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $this->createUser(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameMale(),
            birthdate: new \DateTimeImmutable('-31 years'),
            gender: Gender::Male,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::MALE_PROFILE),
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $this->createUser(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameMale(),
            birthdate: new \DateTimeImmutable('-17 years'),
            gender: Gender::Male,
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
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::MALE_PROFILE),
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $this->createUser(
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
            medicalCertificateExpiry:new \DateTimeImmutable('-1 day'),
            tutorLastname: $faker->lastName(),
            tutorFirstname: $faker->firstName(),
            tutorPhone: $faker->numerify('0#########'),
            tutorEmail: $faker->unique()->safeEmail(),
            tutorAddress: $faker->buildingNumber() . ' ' . $faker->streetName(),
            tutorPostalcode: $faker->postcode(),
            tutorCity: $faker->city(),
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::FEMALE_PROFILE),
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $this->createUser(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameFemale(),
            birthdate: new \DateTimeImmutable('-22 years'),
            gender: Gender::Female,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            medicalCertificateExpiry:new \DateTimeImmutable('-1 day'),
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::FEMALE_PROFILE),
        );

        $this->createUser(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameFemale(),
            birthdate: new \DateTimeImmutable('-18 years'),
            gender: Gender::Female,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::FEMALE_PROFILE),
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $this->createUser(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameFemale(),
            birthdate: new \DateTimeImmutable('-43 years'),
            gender: Gender::Female,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::FEMALE_PROFILE),
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $this->createUser(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameFemale(),
            birthdate: new \DateTimeImmutable('-16 years'),
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
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::FEMALE_PROFILE),
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $this->createUser(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstName(),
            birthdate: new \DateTimeImmutable('-21 years'),
            gender: Gender::Other,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::OTHER_PROFILE),
        );

        $this->createUser(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameMale(),
            birthdate: new \DateTimeImmutable('-29 years'),
            gender: Gender::Male,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::MALE_PROFILE),
            role: Role::President,
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $this->createUser(
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
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::MALE_PROFILE),
            role: Role::VicePresident,
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $this->createUser(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameMale(),
            birthdate: new \DateTimeImmutable('-21 years'),
            gender: Gender::Male,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::MALE_PROFILE),
            role: Role::Treasurer,
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $secretaryUser = $this->createUser(
            manager: $manager,
            lastname: $faker->lastName(),
            firstname: $faker->firstNameFemale(),
            birthdate: new \DateTimeImmutable('-22 years'),
            gender: Gender::Female,
            phone: $faker->numerify('0#########'),
            address: $faker->buildingNumber() . ' ' . $faker->streetName(),
            postalcode: $faker->postcode(),
            city: $faker->city(),
            email: $faker->unique()->safeEmail(),
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::FEMALE_PROFILE),
            role: Role::Secretary,
            badgeNumber: $faker->unique()->numerify('000#######'),
        );

        $this->addReference('secretary_user', $secretaryUser);

        $manager->flush();
    }

    private function createUser(
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
        ?\DateTimeImmutable $medicalCertificateExpiry = new \DateTimeImmutable('+1 year'),
        ?int $accessBadgeDeposit = 10,
        ?int $annualMembershipFee = 50,
        ?Role $role = null,
        ?string $tutorLastname = null,
        ?string $tutorFirstname = null,
        ?string $tutorPhone = null,
        ?string $tutorEmail = null,
        ?string $tutorAddress = null,
        ?string $tutorPostalcode = null,
        ?string $tutorCity = null,
        ?string $profileImage = null,
        ?string $badgeNumber = null,
    ): User
    {
        $user = User::create(
            lastname: $lastname,
            firstname: $firstname,
            birthdate: $birthdate,
            gender: $gender,
            phone: $phone,
            address: $address,
            postalcode: $postalcode,
            city: $city,
            email: $email,
            medicalCertificateExpiry: $medicalCertificateExpiry,
            accessBadgeDeposit: $accessBadgeDeposit,
            annualMembershipFee: $annualMembershipFee,
            tutorLastname: $tutorLastname,
            tutorFirstname: $tutorFirstname,
            tutorPhone: $tutorPhone,
            tutorEmail: $tutorEmail,
            tutorAddress: $tutorAddress,
            tutorPostalcode: $tutorPostalcode,
            tutorCity: $tutorCity,
            profileImage: $profileImage,
        );

        $user->giveBadgeNumber($badgeNumber);

        if (null !== $role) {
            $user->assignRoles([$role]);
        }

        $manager->persist($user);

        return $user;
    }
}
