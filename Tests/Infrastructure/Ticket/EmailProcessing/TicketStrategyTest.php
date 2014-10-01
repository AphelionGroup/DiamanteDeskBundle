<?php
/*
 * Copyright (c) 2014 Eltrino LLC (http://eltrino.com)
 *
 * Licensed under the Open Software License (OSL 3.0).
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://opensource.org/licenses/osl-3.0.php
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eltrino.com so we can send you a copy immediately.
 */
namespace Diamante\DeskBundle\Tests\Infrastructure\Ticket\EmailProcessing;

use Diamante\EmailProcessingBundle\Model\Message;
use Eltrino\PHPUnit\MockAnnotations\MockAnnotations;
use Diamante\DeskBundle\Infrastructure\Ticket\EmailProcessing\TicketStrategy;
use Diamante\DeskBundle\Api\Command\CreateTicketFromMessageCommand;
use Diamante\DeskBundle\Api\Command\CreateCommentFromMessageCommand;

class TicketStrategyTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_UNIQUE_ID  = 'dummy_unique_id';
    const DUMMY_MESSAGE_ID = 'dummy_message_id';
    const DUMMY_SUBJECT    = 'dummy_subject';
    const DUMMY_CONTENT    = 'dummy_content';
    const DUMMY_REFERENCE  = 'dummy_reference';

    /**
     * @var TicketStrategy
     */
    private $ticketStrategy;

    /**
     * @var \Diamante\DeskBundle\Model\Ticket\EmailProcessing\Services\MessageReferenceServiceImpl
     * @Mock \Diamante\DeskBundle\Model\Ticket\EmailProcessing\Services\MessageReferenceServiceImpl
     */
    private $messageReferenceService;

    protected function setUp()
    {
        MockAnnotations::init($this);
        $this->ticketStrategy = new TicketStrategy($this->messageReferenceService);
    }

    public function testProcessWhenMessageWithoutReference()
    {
        $message = new Message(self::DUMMY_UNIQUE_ID, self::DUMMY_MESSAGE_ID, self::DUMMY_SUBJECT,
            self::DUMMY_CONTENT);

        $branchId   = 1;
        $reporterId = 1;
        $assigneeId = 1;

        $createTicketFromMessageCommand = new CreateTicketFromMessageCommand();
        $createTicketFromMessageCommand->messageId   = $message->getMessageId();
        $createTicketFromMessageCommand->branchId    = $branchId;
        $createTicketFromMessageCommand->subject     = $message->getSubject();
        $createTicketFromMessageCommand->description = $message->getContent();
        $createTicketFromMessageCommand->reporterId  = $reporterId;
        $createTicketFromMessageCommand->assigneeId  = $assigneeId;


        $this->messageReferenceService->expects($this->once())
            ->method('createTicket')
            ->with($this->equalTo($createTicketFromMessageCommand));

        $this->ticketStrategy->process($message);
    }

    public function testProcessWhenMessageWithReference()
    {
        $message = new Message(self::DUMMY_UNIQUE_ID, self::DUMMY_MESSAGE_ID, self::DUMMY_SUBJECT,
            self::DUMMY_CONTENT, self::DUMMY_REFERENCE);

        $reporterId = 1;

        $createCommentFromMessageCommand = new CreateCommentFromMessageCommand();
        $createCommentFromMessageCommand->authorId  = $reporterId;
        $createCommentFromMessageCommand->content   = $message->getContent();
        $createCommentFromMessageCommand->messageId = $message->getReference();

        $this->messageReferenceService->expects($this->once())
            ->method('createCommentForTicket')
            ->with($this->equalTo($createCommentFromMessageCommand));

        $this->ticketStrategy->process($message);
    }
}
