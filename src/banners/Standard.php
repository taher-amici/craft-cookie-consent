<?php

namespace elleracompany\cookieconsent\banners;

use elleracompany\cookieconsent\interfaces\TemplateTypeInterface;

class Standard implements TemplateTypeInterface
{
    public static function templateName(): string
    {
        return 'Standard Template';
    }
}