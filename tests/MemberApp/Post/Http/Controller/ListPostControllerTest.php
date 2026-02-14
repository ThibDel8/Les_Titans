<?php

declare(strict_types=1);

namespace App\Tests\MemberApp\Post\Http\Controller;

use App\DataFixtures\UserFixtures;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class ListPostControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = '/posts';
    }

    public function testDenyAccess(): void
    {
        $this->client->request(Request::METHOD_GET, $this->url);

        self::assertResponseRedirects('/login');
    }

    public function testPostList(): void
    {
        $browser = self::getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
