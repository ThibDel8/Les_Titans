<?php

declare(strict_types=1);

namespace App\Tests\Admin\Membership\Http\Controller\Crud;

use App\DataFixtures\UserFixtures;
use App\MemberApp\Membership\Domain\Entity\Membership;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class DeleteMembershipControllerTest extends AbstractWebTestCase
{
    private Membership $membership;
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->membership = self::getRepository(Membership::class)->findOneBy([]);
        $this->url = \sprintf('/admin/memberships/%s/delete', $this->membership->getId());
    }

    public function testDenyAccess(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteMembership(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        self::getEntityManager()->clear();
        $deletedMembership = self::getRepository(Membership::class)->find($this->membership->getId());

        self::assertNull($deletedMembership);
    }
}
