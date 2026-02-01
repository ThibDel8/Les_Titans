<?php

declare(strict_types=1);

namespace App\Tests\PublicApp\Legals\Http\Controller;

use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
final class HouseRulesControllerTest extends AbstractWebTestCase
{
    private string $url;
    protected function setUp(): void
    {
        parent::setUp();

        $this->url = '/house-rules';
    }

    public function testIndex(): void
    {
        $this->client->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
