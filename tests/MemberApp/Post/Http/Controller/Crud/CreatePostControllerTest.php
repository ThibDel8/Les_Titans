<?php

declare(strict_types=1);

namespace App\Tests\MemberApp\Post\Http\Controller\Crud;

use App\DataFixtures\UserFixtures;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class CreatePostControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = '/posts/create';
    }

    public function testDenyAccess(): void
    {
        $this->client->request(Request::METHOD_GET, $this->url);

        self::assertResponseRedirects('/login');
    }

    public function testPostCreate(): void
    {
        $browser = self::getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $browser->submitForm('Publier', ['create_post[text]' => 'test']);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $browser->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
