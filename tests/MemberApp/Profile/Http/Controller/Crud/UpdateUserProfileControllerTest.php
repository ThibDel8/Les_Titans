<?php

declare(strict_types=1);

namespace App\Tests\MemberApp\Profile\Http\Controller\Crud;

use App\DataFixtures\UserFixtures;
use App\SharedKernel\Domain\Enum\Gender;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class UpdateUserProfileControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = '/profile/edit';
    }

    public function testDenyAccess(): void
    {
        $this->client->request(method: Request::METHOD_GET, uri: $this->url);

        self::assertResponseRedirects('/login');
    }

    public function testUpdateProfile(): void
    {
        $client = self::getLoggedUser(UserFixtures::USER_MINOR_MEMBER_ID);
        $client->request(method: Request::METHOD_GET, uri: $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $client->submitForm('Enregistrer', [
            'profile[lastname]' => 'Lastname',
            'profile[firstname]' => 'Firstname',
            'profile[birthdate]' => '2015-01-01',
            'profile[gender]' => Gender::Male->value,
            'profile[phone]' => '0666666666',
            'profile[address]' => '5 avenue de Quelque Part',
            'profile[postalcode]' => '80500',
            'profile[city]' => 'Cityville',
            'profile[email]' => 'random-address@email.fr',
            'profile[tutorLastname]' => 'Tutorlastname',
            'profile[tutorFirstname]' => 'Tutorfirstname',
            'profile[tutorPhone]' => '0666666669',
            'profile[tutorEmail]' => 'tutor-address@email.fr',
            'profile[tutorAddress]' => '5 avenue de Quelque Part',
            'profile[tutorPostalcode]' => '80500',
            'profile[tutorCity]' => 'Cityville',
        ]);

        $client->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
