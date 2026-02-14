<?php

declare(strict_types=1);

namespace App\Tests\Admin\Contact\Http\Controller\Crud;

use App\DataFixtures\ContactMessageFixtures;
use App\DataFixtures\UserFixtures;
use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use App\PublicApp\Contact\Domain\Enum\ContactMessageStatus;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
final class UpdateContactMessageControllerTest extends AbstractWebTestCase
{
    private ContactMessage $contactMessage;
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->contactMessage = self::getRepository(ContactMessage::class)->find(['id' => ContactMessageFixtures::ASSIGNED_CONTACT_MESSAGE_ID]);
        $this->url = \sprintf('/admin/contact-messages/%s/unread', $this->contactMessage->getId());

    }

    public function testDenyAccess(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testMarkAsUnreadContactMessage(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_POST, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        self::getEntityManager()->clear();
        $updatedContactMessage = self::getRepository(ContactMessage::class)->find($this->contactMessage->getId());

        self::assertSame(ContactMessageStatus::NEW, $updatedContactMessage->getStatus());
    }
}
