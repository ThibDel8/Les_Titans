<?php

declare(strict_types=1);

namespace App\Tests\Admin\Membership\Http\Controller\Crud;

use App\Admin\Membership\Http\Controller\Crud\ReadMembershipController;
use App\DataFixtures\UserFixtures;
use App\MemberApp\Membership\Domain\Entity\Membership;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class ReadMembershipControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $membership = self::getRepository(Membership::class)->findOneBy([]);
        $this->url = \sprintf('/admin/memberships/%s', $membership->getId());
    }

    public function testDenyAccess(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testReadMembership(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testValidateMembership(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        $browser->submitForm('Enregistrer', [
            'validate_membership[medicalCertificateExpiry]' => '2500-01-31',
            'validate_membership[accessBadgeDeposit]' => true,
            'validate_membership[annualMembershipFee]' => true,
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $browser->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
