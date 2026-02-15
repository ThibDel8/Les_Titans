<?php

declare(strict_types=1);

namespace App\Tests\MemberApp\Post\Http\Controller\Crud;

use App\DataFixtures\PostFixtures;
use App\DataFixtures\UserFixtures;
use App\MemberApp\Post\Domain\Entity\Post;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class DeletePostControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = \sprintf('/posts/%s/delete', PostFixtures::ID_SECRETARY_POST);
    }

    public function testDenyAccess(): void
    {
        $client = self::getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $client->request(method: Request::METHOD_POST, uri: $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDeletePost(): void
    {
        $client = self::getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $client->request(method: Request::METHOD_POST, uri: $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $deletedPost = self::getRepository(Post::class)->find(PostFixtures::ID_SECRETARY_POST);
        self::assertNull($deletedPost);
    }
}
