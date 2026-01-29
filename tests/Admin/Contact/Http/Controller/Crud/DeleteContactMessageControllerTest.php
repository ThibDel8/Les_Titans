<?php

declare(strict_types=1);

namespace App\Tests\Admin\Contact\Http\Controller\Crud;

use App\Admin\Contact\Http\Controller\Crud\DeleteContactMessageController;
use App\DataFixtures\UserFixtures;
use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use App\Tests\AbstractWebTestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
final class DeleteContactMessageControllerTest extends AbstractWebTestCase
{
    private ContactMessage $contactMessage;
    private string $url;
    protected function setUp(): void
    {
        parent::setUp();
        $this->contactMessage = self::getRepository(ContactMessage::class)->findOneBy([]);
        $this->url = \sprintf('/admin/contact-messages/%s/delete', $this->contactMessage->getId());
    }

    public function testDenyAccess(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteContactMessage(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        self::getEntityManager()->clear();
        $deletedMessage = self::getRepository(ContactMessage::class)->find($this->contactMessage->getId());

        self::assertNull($deletedMessage);
    }
}
