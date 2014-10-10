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

namespace Diamante\DeskBundle\Infrastructure\Ticket\Filters;

use Oro\Bundle\FilterBundle\Form\Type\Filter\TextFilterType;

class AbstractFilterUrlGenerator
{
    /**
     * @var string
     */
    protected $defaultPerPage;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var int
     */
    protected $textFiltertype;

    /**
     * @param $userId
     * @param $defaultPerPage
     */
    public function __construct($defaultPerPage, $userId)
    {
        $this->defaultPerPage = $defaultPerPage;
        $this->userId         = $userId;
        $this->textFiltertype = TextFilterType::TYPE_EQUAL;
    }

    /**
     * @param $string
     * @return string
     */
    protected function encodeSquareBrackets($string = '')
    {
        return urlencode('[') . $string . urlencode(']');
    }
}