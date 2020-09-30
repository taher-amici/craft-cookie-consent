<?php

namespace elleracompany\cookieconsent\banners\standard;

use elleracompany\cookieconsent\banners\standard\models\Settings;
use elleracompany\cookieconsent\interfaces\BannerInterface;
use elleracompany\cookieconsent\interfaces\BannerSettingsModelInterface;

class Banner implements BannerInterface
{
    public static function templateName(): string
    {
        return 'Standard Template';
    }

    public static function templateSlug(): string
    {
        return 'standard';
    }

    public static function settingsModel(): BannerSettingsModelInterface
    {
        return new Settings();
    }

    public static function cpTemplatePath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'cp';
    }

    public static function siteTemplatePath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'site';
    }
}