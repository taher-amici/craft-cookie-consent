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

    public static function twigPath(): string
    {
        return dirname(__DIR__) . '/templates';
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
        return Craft::$app->view->renderTemplate('_craft_cookie_consent_'.self::bannerClass()::templateSlug().'/_settings', ['model' => new self], View::TEMPLATE_MODE_CP);
    }
}