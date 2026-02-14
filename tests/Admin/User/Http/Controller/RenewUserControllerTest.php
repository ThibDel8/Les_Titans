<?php

declare(strict_types=1);

namespace App\Tests\Admin\User\Http\Controller;

use App\Admin\User\Domain\Entity\User;
use App\DataFixtures\UserFixtures;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class RenewUserControllerTest extends AbstractWebTestCase
{
    private User $user;
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = self::getRepository(User::class)->findOneBy(['annualMembershipFee' => null]);
        $this->url = \sprintf('/admin/users/%s/renew', $this->user->getId());
    }

    public function testDenyAccess(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testRenewUser(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        self::getEntityManager()->clear();
        $renewedUser = self::getRepository(User::class)->find($this->user->getId());

        self::assertSame(50, $renewedUser->getAnnualMembershipFee());
    }
}
