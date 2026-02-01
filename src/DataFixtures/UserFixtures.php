<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Faker\Factory;
use App\Admin\User\Domain\Entity\User;
use App\SharedKernel\Domain\Enum\Role;
use Doctrine\Persistence\ObjectManager;
use App\SharedKernel\Domain\Enum\Gender;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\SharedKernel\Domain\Service\ProfileImage\ProfileImageService;
use Random\RandomException;

class UserFixtures extends Fixture
{
    public const string USER_VICE_PRESIDENT_ID = 'a6ee5cfc-3ee3-4936-aec4-8d10a6b4cbbd';
    public const string USER_SECRETARY_ID = '181c37fd-3bd0-4d88-9322-a0e4213e57b2';
    public const string USER_MEMBER_ID = '3bac373a-840b-4fe4-93dc-19921c912169';

    public const int USER_MEMBER_BADGE_NUMBER = 0001234567;

    public function __construct(private readonly ProfileImageService $profileImageService)
    {
    }

    /**
     * @throws RandomException
     */
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
            id: self::USER_MEMBER_ID,
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
            annualMembershipFee: null,
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::MALE_PROFILE),
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
            accessBadgeDeposit: self::USER_MEMBER_BADGE_NUMBER,
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
            role: Role::President,
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::MALE_PROFILE),
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
            role: Role::VicePresident,
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::MALE_PROFILE),
            badgeNumber: $faker->unique()->numerify('000#######'),
            id: self::USER_VICE_PRESIDENT_ID,
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
            role: Role::Treasurer,
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::MALE_PROFILE),
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
            role: Role::Secretary,
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::FEMALE_PROFILE),
            badgeNumber: $faker->unique()->numerify('000#######'),
            id: self::USER_SECRETARY_ID,
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
        ?string $id = null,
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
            id: $id,
        );

        $user->giveBadgeNumber($badgeNumber);

        if (null !== $role) {
            $user->assignRoles([$role]);
        }

        $manager->persist($user);

        return $user;
    }
}
