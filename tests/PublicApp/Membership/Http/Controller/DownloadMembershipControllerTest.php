<?php

declare(strict_types=1);

namespace App\Tests\PublicApp\Membership\Http\Controller;

use App\MemberApp\Membership\Domain\Entity\Membership;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
final class DownloadMembershipControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $membership = self::getRepository(Membership::class)->findOneBy([]);
        $this->url = \sprintf('/memberships/%s/download', $membership->getId());
    }

    public function testIndex(): void
    {
        ob_start();
        $this->client->request(Request::METHOD_GET, $this->url);
        ob_end_clean();

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
