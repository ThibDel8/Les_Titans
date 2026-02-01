<?php

declare(strict_types=1);

namespace App\Tests\PublicApp\About\Http\Controller;

use App\PublicApp\About\Http\Controller\AboutController;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
final class AboutControllerTest extends AbstractWebTestCase
{
    private string $url;
    protected function setUp(): void
    {
        parent::setUp();
        $this->url = '/about';
    }

    public function testIndex(): void
    {
        $this->client->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
