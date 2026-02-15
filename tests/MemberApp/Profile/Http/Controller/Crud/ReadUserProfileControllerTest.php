<?php

declare(strict_types=1);

namespace App\Tests\MemberApp\Profile\Http\Controller\Crud;

use App\DataFixtures\UserFixtures;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class ReadUserProfileControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = '/profile';
    }

    public function testDenyAccess(): void
    {
        $this->client->request(method: Request::METHOD_GET, uri: $this->url);

        self::assertResponseRedirects('/login');
    }

    public function testReadProfile(): void
    {
        $client = self::getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $client->request(method: Request::METHOD_GET, uri: $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
