<?php

declare(strict_types=1);

namespace App\Tests\Admin\User\Http\Controller\Crud;

use App\Admin\User\Http\Controller\Crud\CreateUserController;
use App\DataFixtures\UserFixtures;
use App\MemberApp\Membership\Domain\Entity\Membership;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class CreateUserControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $membership = self::getRepository(Membership::class)->findOneBy([]);
        $this->url = \sprintf('admin/users/create/%s', $membership->getId());
    }

    public function testDenyAccess(): void
    {
        $browser = self::getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testCreateUser(): void
    {
        $browser = self::getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
