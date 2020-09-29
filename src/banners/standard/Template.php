<?php

namespace elleracompany\cookieconsent\banners\standard;

use elleracompany\cookieconsent\interfaces\TemplateTypeInterface;

class Template implements TemplateTypeInterface
{
    public static function templateName(): string
    {
        return 'Standard Template';
    }
}