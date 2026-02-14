<?php

declare(strict_types=1);

namespace App\Tests\Admin\User\Http\Controller\Crud;

use App\Admin\User\Domain\Entity\User;
use App\DataFixtures\UserFixtures;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class DeleteUserControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = \sprintf('/admin/user/%s/delete', UserFixtures::USER_MEMBER_ID);
    }

    public function testDenyAccess(): void
    {
        $browser = self::getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteUser(): void
    {
        $browser = self::getLoggedUser(UserFixtures::USER_VICE_PRESIDENT_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $deletedUser = self::getRepository(User::class)->find(UserFixtures::USER_MEMBER_ID);
        self::assertNull($deletedUser);
    }
}
