<?php

namespace elleracompany\cookieconsent\migrations;

use Craft;
use craft\db\Migration;
Use craft\db\Table;
use elleracompany\cookieconsent\CookieConsent;

/**
 * Install migration.
 */
class Install extends Migration
{
	/**
	 * @inheritdoc
	 */
	public function safeUp()
	{
		// Site Settings
		$this->createTable(
			CookieConsent::SITE_SETTINGS_TABLE,
			[
				'site_id' => $this->integer(11),
				'dateCreated' => $this->dateTime()->notNull(),
				'dateUpdated' => $this->dateTime()->notNull(),
				'uid'         => $this->uid(),
				'activated' => $this->boolean()->notNull()->defaultValue(false),
				'cssAssets' => $this->boolean()->notNull()->defaultValue(true),
				'jsAssets' => $this->boolean()->notNull()->defaultValue(true),
				'templateAsset' => $this->boolean()->notNull()->defaultValue(true),
				'showCheckboxes' => $this->boolean()->notNull()->defaultValue(true),
				'showAfterConsent' => $this->boolean()->notNull()->defaultValue(true),
                'cookieName' => $this->string()->notNull()->defaultValue('cookie-consent'),
                'acceptAllButton' => $this->boolean()->notNull()->defaultValue(false),
				'headline' => $this->string(255)->notNull(),
				'description' => $this->text(),
                'refresh' => $this->boolean()->notNull()->defaultValue(false),
                'refresh_time' => $this->integer()->notNull()->defaultValue(500),
                'template_class' => $this->string(),
                'template_settings' => $this->text()
			]
		);
		$this->addPrimaryKey(
			'pk_cookie_consent_site_settings',
			CookieConsent::SITE_SETTINGS_TABLE,
			'site_id'
		);
		$this->addForeignKey(
			'fk_cookie_consent_setting_belong_to_site',
			CookieConsent::SITE_SETTINGS_TABLE,
			'site_id',
			Table::SITES,
			'id',
            'CASCADE',
            'CASCADE'
		);

		// Group Settings
		$this->createTable(
			CookieConsent::COOKIE_GROUP_TABLE,
			[
				'id' => $this->primaryKey(),
				'uid'         => $this->uid(),
				'name' => $this->string(),
				'slug' => $this->string(),
				'required' => $this->boolean()->notNull(),
				'store_ip' => $this->boolean()->notNull(),
				'default' => $this->boolean()->notNull(),
				'cookies' => $this->text(),
				'description' => $this->text(),
				'site_id' => $this->integer(11),
				'dateCreated' => $this->dateTime()->notNull(),
				'dateUpdated' => $this->dateTime()->notNull(),
                'order' => $this->integer()
			]
		);
		$this->addForeignKey(
			'fk_cookie_consent_group_belong_to_site',
			CookieConsent::COOKIE_GROUP_TABLE,
			'site_id',
			Table::SITES,
			'id',
			'CASCADE',
			'CASCADE'
		);

		// Consent
		$this->createTable(
			CookieConsent::CONSENT_TABLE,
			[
				'uid'         => $this->uid(),
				'site_id' => $this->integer(11),
				'ip' => $this->string(15)->defaultValue(null),
				'data' => $this->text(),
                'cookieName' => $this->string()->defaultValue('cookie-consent'),
				'dateCreated' => $this->dateTime()->notNull(),
				'dateUpdated' => $this->dateTime()->notNull(),
			]
		);
		$this->addPrimaryKey(
			'pk_cookie_consent_consent',
			CookieConsent::CONSENT_TABLE,
			'uid'
		);
		$this->addForeignKey(
			'fk_cookie_consent_consent_belong_to_site',
			CookieConsent::CONSENT_TABLE,
			'site_id',
			Table::SITES,
			'id',
			'CASCADE',
			'CASCADE'
		);
		return true;
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown()
	{
		$this->dropTableIfExists(CookieConsent::CONSENT_TABLE);
		$this->dropTableIfExists(CookieConsent::COOKIE_GROUP_TABLE);
		$this->dropTableIfExists(CookieConsent::SITE_SETTINGS_TABLE);
		return true;
	}
}
