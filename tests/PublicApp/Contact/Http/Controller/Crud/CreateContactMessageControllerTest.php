<?php

declare(strict_types=1);

namespace App\Tests\PublicApp\Contact\Http\Controller\Crud;

use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
final class CreateContactMessageControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();
        $this->url = '/contact';
    }

    public function testIndex(): void
    {
        $this->client->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateContactMessage(): void
    {
        $this->client->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->client->submitForm('Envoyer', [
            'contact_message[email]' => 'random-address@email.fr',
            'contact_message[subject]' => 'Test message',
            'contact_message[body]' => 'Test message',
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
