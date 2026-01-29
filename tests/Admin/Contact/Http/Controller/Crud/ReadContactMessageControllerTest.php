<?php

declare(strict_types=1);

namespace App\Tests\Admin\Contact\Http\Controller\Crud;

use App\DataFixtures\UserFixtures;
use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use App\Tests\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('functional')]
final class ReadContactMessageControllerTest extends AbstractWebTestCase
{
    private ContactMessage $contactMessage;
    private string $url;
    protected function setUp(): void
    {
        parent::setUp();

        $this->contactMessage = self::getRepository(ContactMessage::class)->findOneBy([]);
        $this->url = \sprintf('/admin/contact-messages/%s', $this->contactMessage->getId());
    }

    public function testDenyAccess(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_MEMBER_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
    public function testReadContactMessage(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testAnswerContactMessage(): void
    {
        $browser = $this->getLoggedUser(UserFixtures::USER_SECRETARY_ID);
        $browser->request(Request::METHOD_GET, $this->url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $browser->submitForm('Répondre', ['answer_contact_message[answer]' => 'Voici ma réponse.']);

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $browser->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
