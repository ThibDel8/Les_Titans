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
class ReadUserControllerTest extends AbstractWebTestCase
{
    private User $user;
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = self::getRepository(User::class)->findOneBy(['accessBadgeNumber' => null]);
        $this->url = \sprintf('/admin/users/%s', $this->user->getId());
    }

    public function testDenyAccess(): void
    {
        $browser = self::getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testAssignUserBadgeNumber(): void
    {
        $browser = self::getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $browser->submitForm('Enregistrer', ['user_access_badge[accessBadgeNumber]' => '0001234567']);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $browser->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
