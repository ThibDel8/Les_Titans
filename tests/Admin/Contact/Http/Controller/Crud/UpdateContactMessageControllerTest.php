<?php

declare(strict_types=1);

namespace App\Tests\Admin\Contact\Http\Controller\Crud;

use App\Admin\Contact\Http\Controller\Crud\UpdateContactMessageController;
use App\DataFixtures\UserFixtures;
use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use App\PublicApp\Contact\Domain\Enum\ContactMessageStatus;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
final class UpdateContactMessageControllerTest extends AbstractWebTestCase
{
    private string $contactMessageId;
    private string $url;
    protected function setUp(): void
    {
        parent::setUp();

        $contactMessage = self::getRepository(ContactMessage::class)->findOneBy(['status' => ContactMessageStatus::IN_PROGRESS]);
        $this->contactMessageId = $contactMessage->getId();
        $this->url = \sprintf('/admin/contact-messages/%s/unread', $this->contactMessageId);

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
        $updatedContactMessage = self::getRepository(ContactMessage::class)->find($this->contactMessageId);

        self::assertSame(ContactMessageStatus::NEW, $updatedContactMessage->getStatus());
    }
}
