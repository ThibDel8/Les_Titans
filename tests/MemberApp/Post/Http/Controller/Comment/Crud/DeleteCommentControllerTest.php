<?php

declare(strict_types=1);

namespace App\Tests\MemberApp\Post\Http\Controller\Comment\Crud;

use App\DataFixtures\CommentFixtures;
use App\DataFixtures\UserFixtures;
use App\MemberApp\Post\Domain\Entity\Comment;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class DeleteCommentControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = \sprintf('/posts/comments/%s/delete', CommentFixtures::ID_SECRETARY_COMMENT);
    }

    public function testDenyAccess(): void
    {
        $client = self::getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $client->request(method: Request::METHOD_POST, uri: $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteComment(): void
    {
        $client = self::getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $client->request(method: Request::METHOD_POST, uri: $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $deletedComment = self::getRepository(Comment::class)->find(CommentFixtures::ID_SECRETARY_COMMENT);
        self::assertNull($deletedComment);
    }
}
