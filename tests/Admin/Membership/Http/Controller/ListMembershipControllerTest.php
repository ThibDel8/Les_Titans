<?php

declare(strict_types=1);

namespace App\Tests\Admin\Membership\Http\Controller;

use App\Admin\Membership\Http\Controller\ListMembershipController;
use App\DataFixtures\UserFixtures;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class ListMembershipControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = '/admin/memberships';
    }

    public function testDenyAccess(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testIndex(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
