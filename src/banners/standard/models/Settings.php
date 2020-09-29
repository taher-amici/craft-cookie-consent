<?php

namespace elleracompany\cookieconsent\banners\standard\models;

use elleracompany\cookieconsent\interfaces\TemplateSettingsModelInterface;

class Settings implements TemplateSettingsModelInterface
{

    public $cssAssets;
    public $jsAssets;
    public $templateAsset;
    public $showCheckboxes;
    public $showAfterConsent;
    public $acceptAllButton;
    public $headline;
    public $description;

    public function load(array $data)
    {
        foreach ($data as $attribute => $value) if(property_exists(self::class, $attribute)) $this->$attribute = $value;
    }
}