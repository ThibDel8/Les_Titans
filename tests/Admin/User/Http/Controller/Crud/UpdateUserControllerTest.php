<?php

declare(strict_types=1);

namespace App\Tests\Admin\User\Http\Controller\Crud;

use App\Admin\User\Domain\Entity\User;
use App\DataFixtures\UserFixtures;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
class UpdateUserControllerTest extends AbstractWebTestCase
{
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $user = self::getRepository(User::class)->findOneBy([]);
        $this->url = \sprintf('/admin/users/%s/update', $user->getId());
    }

    public function testDenyAccess(): void
    {
        $browser = self::getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testUpdateUser(): void
    {
        $browser = self::getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $crawler = $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Enregistrer')->form();

        $form['update_user[lastname]'] = 'Nouveau Nom';

        $browser->submit($form);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $browser->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
