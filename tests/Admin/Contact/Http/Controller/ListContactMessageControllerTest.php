<?php

declare(strict_types=1);

namespace App\Tests\Admin\Contact\Http\Controller;

use App\DataFixtures\UserFixtures;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
final class ListContactMessageControllerTest extends AbstractWebTestCase
{
    private string $url;
    protected function setUp(): void
    {
        parent::setUp();
        $this->url = '/admin/contact-messages';
    }

    public function testDenyAccess(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testContactMessageList(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
