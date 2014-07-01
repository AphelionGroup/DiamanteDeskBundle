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
namespace Eltrino\DiamanteDeskBundle\Attachment\Api;

use Eltrino\DiamanteDeskBundle\Attachment\Model\AttachmentHolder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface AttachmentService
{
    /**
     * Create Attachment
     * @param UploadedFile $uploadedFile
     * @param AttachmentHolder $attachmentHolder
     * @return int
     */
    public function createAttachment(UploadedFile $uploadedFile, AttachmentHolder $attachmentHolder);

    /**
     * Remove Attachment
     * @param $attachmentId
     * @return void
     * @throws \RuntimeException if error occures during removing
     */
    public function removeAttachment($attachmentId);
}