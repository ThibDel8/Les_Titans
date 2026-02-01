<?php

declare(strict_types=1);

namespace App\Tests\PublicApp\Membership\Http\Controller\Crud;

use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
final class CreateMembershipControllerTest extends AbstractWebTestCase
{
    private string $url;
    protected function setUp(): void
    {
        parent::setUp();

        $this->url = '/memberships/create';
    }

    public function testIndex(): void
    {
        $this->client->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateMembership(): void
    {
        $this->client->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
