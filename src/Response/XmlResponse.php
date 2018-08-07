<?php

namespace Grizmar\Api\Response;


class XmlResponse extends BaseResponse
{
    public const CONTENT_TYPE = 'application/xml';

    public function __construct()
    {
        $this->header('Content-Type', static::CONTENT_TYPE);
    }
}
