<?php

namespace elleracompany\cookieconsent\migrations;

use craft\db\Migration;
use elleracompany\cookieconsent\banners\standard\models\Settings;
use elleracompany\cookieconsent\CookieConsent;
use elleracompany\cookieconsent\records\SiteSettings;

/**
 * m200810_141923_v2_0
 */
class m200810_141923_v2_0 extends Migration
{
	/**
	 * @inheritdoc
	 */
	public function safeUp()
	{
        $siteSettings = (new \craft\db\Query())
            ->select([
                'site_id',
                'cssAssets',
                'jsAssets',
                'templateAsset',
                'showCheckboxes',
                'showAfterConsent',
                'acceptAllButton',
                'headline',
                'description'
            ])
            ->from(CookieConsent::SITE_SETTINGS_TABLE)
            ->all();

        $this->dropColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'template'
        );
        $this->dropColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'cssAssets'
        );
        $this->dropColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'jsAssets'
        );
        $this->dropColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'templateAsset'
        );
        $this->dropColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'showCheckboxes'
        );
        $this->dropColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'showAfterConsent'
        );
        $this->dropColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'acceptAllButton'
        );
        $this->dropColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'headline'
        );
        $this->dropColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'description'
        );
        $this->addColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'template_class',
            $this->string()->defaultValue('elleracompany\cookieconsent\banners\standard\Template')
        );

        $this->addColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'template_settings',
            $this->text()
        );

        foreach ($siteSettings as $settings)
        {
            $settingsModel = new Settings();
            $settingsModel->load($settings);
            $siteSetting = SiteSettings::findOne($settings['site_id']);
            $siteSetting->template_settings = serialize($settingsModel);
            $siteSetting->save();
        }
	}
	/**
	 * @inheritdoc
	 */
	public function safeDown()
	{
		echo "This migration cannot be reverted.";
		return false;
	}
}