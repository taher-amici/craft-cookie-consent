<?php

namespace elleracompany\cookieconsent\interfaces;

interface TemplateTypeInterface
{
    /**
     * Template Type Name
     * Visible in the dropdown in Site Settings
     * @return string
     */
    public static function templateName(): string;
}