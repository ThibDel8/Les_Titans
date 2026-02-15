<?php

declare(strict_types=1);

namespace App\Tests\MemberApp\Post\Http\Controller\Crud;

use App\DataFixtures\PostFixtures;
use App\DataFixtures\UserFixtures;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class ReadPostControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = \sprintf('/posts/%s', PostFixtures::ID_SECRETARY_POST);
    }

    public function testDenyAccess(): void
    {
        $this->client->request(method: Request::METHOD_GET, uri: $this->url);

        self::assertResponseRedirects('/login');
    }

    public function testReadPost(): void
    {
        $client = self::getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $client->request(method: Request::METHOD_GET, uri: $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $client->submitForm('Répondre', ['create_comment[text]' => 'This is a test comment']);

        $client->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
