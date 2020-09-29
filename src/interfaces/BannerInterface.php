<?php

namespace elleracompany\cookieconsent\interfaces;

interface BannerInterface
{
    /**
     * Template Type Name
     * Visible in the dropdown in Site Settings
     * @return string
     */
    public static function templateName(): string;
    public static function templateSlug(): string;
    public static function settingsModel(): BannerSettingsModelInterface;
}