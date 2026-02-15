<?php

declare(strict_types=1);

namespace App\Tests\Admin\Document\Http\Controller;

use App\DataFixtures\UserFixtures;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class DownloadOutdoorInfoSheetControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = '/admin/documents/download-outdoor-info-sheet';
    }

    public function testDenyAccess(): void
    {
        $client = self::getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $client->request(method: Request::METHOD_GET, uri: $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDownloadOutdoorInfoSheet(): void
    {
        ob_start();
        $client = self::getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $client->request(method: Request::METHOD_GET, uri: $this->url);
        ob_end_clean();

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
