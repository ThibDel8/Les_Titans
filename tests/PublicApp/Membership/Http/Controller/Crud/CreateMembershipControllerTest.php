<?php

declare(strict_types=1);

namespace App\Tests\PublicApp\Membership\Http\Controller\Crud;

use App\SharedKernel\Domain\Enum\Gender;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
final class CreateMembershipControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = '/memberships/create';
    }

    public function testIndex(): void
    {
        $this->client->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateMembership(): void
    {
        $this->client->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->client->submitForm('Envoyer la demande', [
            'membership_creation[lastname]' => 'Lastname',
            'membership_creation[firstname]' => 'Firstname',
            'membership_creation[birthdate]' => '1995-01-01',
            'membership_creation[gender]' => Gender::Male->value,
            'membership_creation[phone]' => '0666666666',
            'membership_creation[address]' => '5 avenue de Quelque Part',
            'membership_creation[postalcode]' => '80500',
            'membership_creation[city]' => 'Cityville',
            'membership_creation[email]' => 'random-address@email.fr',
            'membership_creation[acceptedRules]' => true,
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
