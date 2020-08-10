<?php

namespace elleracompany\cookieconsent\migrations;

use craft\db\Migration;
use elleracompany\cookieconsent\CookieConsent;

/**
 * m200810_141923_v1_5
 */
class m200810_141923_v1_5 extends Migration
{
	/**
	 * @inheritdoc
	 */
	public function safeUp()
	{
        $this->addColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'template_class',
            $this->string()
        );
        $this->addColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'template_settings',
            $this->text()
        );
        $this->dropColumn(
            CookieConsent::SITE_SETTINGS_TABLE,
            'template'
        );
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