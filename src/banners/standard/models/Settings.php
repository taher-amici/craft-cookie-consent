<?php

namespace elleracompany\cookieconsent\banners\standard\models;

use Craft;
use craft\base\Model;
use craft\web\View;
use elleracompany\cookieconsent\banners\standard\Banner;
use elleracompany\cookieconsent\interfaces\BannerInterface;
use elleracompany\cookieconsent\interfaces\BannerSettingsModelInterface;

class Settings extends Model implements BannerSettingsModelInterface
{

    public $cssAssets;
    public $jsAssets;
    public $templateAsset;
    public $showCheckboxes;
    public $showAfterConsent;
    public $acceptAllButton;
    public $headline;
    public $description;

    public function loadDataArray(array $data)
    {
        foreach ($data as $attribute => $value) if(property_exists(self::class, $attribute)) $this->$attribute = $value;
    }

    public static function settingsTemplate(): string
    {
        return '_settings';
    }

    public static function bannerClass(): BannerInterface
    {
        return new Banner();
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    public static function getSettingsHtml()
    {
        // TODO: I have no idea how to render a twig template from a folder not contained in cpTemplateRoots
        // TODO: Without registering the cpTemplateRoot in the beginning of runtime
        // Craft::$app->view->cpTemplateRoots['_craft_cookie_consent_'.self::bannerClass()::templateSlug()] = self::templatePath();
        return Craft::$app->view->renderTemplate('_craft_cookie_consent_'.self::bannerClass()::templateSlug(), ['model' => new self], View::TEMPLATE_MODE_CP);
    }
}