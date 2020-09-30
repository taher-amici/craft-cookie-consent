<?php


namespace elleracompany\cookieconsent\records;

use Craft;
use craft\db\ActiveRecord;
use craft\records\Site;
use craft\web\View;
use elleracompany\cookieconsent\CookieConsent;
use elleracompany\cookieconsent\interfaces\BannerInterface;
use yii\db\ActiveQueryInterface;
use yii\web\NotFoundHttpException;

/**
 * @property boolean 	$activated
 * @property boolean    $refresh
 * @property string     $cookieName
 * @property integer 	$site_id
 * @property integer    $refresh_time
 * @property string		$template_class
 * @property string     $template_settings
 */
class SiteSettings extends ActiveRecord
{

    private $banners;

	/**
	 * @inheritdoc
	 */
	public function fields()
	{
		$fields = [
			'site_id',
			'activated',
            'cookieName',
            'refresh',
            'refresh_time',
            'template_class',
            'template_settings'
		];
		return array_merge($fields, parent::fields());
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName(): string
	{
		return CookieConsent::SITE_SETTINGS_TABLE;
	}

    /**
     * @inheritDoc
     */
	public function rules()
	{
		return [
			[['cookieName', 'template_class', 'template_settings'], 'string'],
			[['template_class'], 'required'],
			[['activated', 'refresh'], 'boolean'],
			[['activated'], 'validatePermission'],
			[['activated', 'refresh'], 'default', 'value' => 0],
			[['site_id', 'refresh_time'], 'integer']
		];
	}

    /**
     * @inheritDoc
     */
	public function attributeLabels()
	{
		return [
			'site_id' => Craft::t('cookie-consent', 'Site ID'),
			'activated' => Craft::t('cookie-consent', 'Activated'),
            'cookieName' => Craft::t('cookie-consent', 'Name of the consent cookie'),
            'refresh' => Craft::t('cookie-consent', 'Automatic Refresh'),
            'refresh_time' => Craft::t('cookie-consent', 'Refresh Time'),
            'template_class' => Craft::t('cookie-consent', 'Template Class'),
            'template_settings' => Craft::t('cookie-consent', 'Template Settings')
		];
	}

	private function getBanners()
    {
        if(!$this->banners)
        {
            $plugin = CookieConsent::getInstance();
            $this->banners = $plugin->getBannerTemplates();
        }

        return $this->banners;
    }

    public function getBannerDropdown()
    {
        return $this->getBanners()['dropdown'];
    }

    public function getBannerList()
    {
        return $this->getBanners()['classes'];
    }

    public function getBannerSettingsHtml($slug)
    {
        $banners = $this->getBanners();
        if(isset($banners['classes'][$slug])) {
            /** @var $classname BannerInterface */
            $classname = $banners['classes'][$slug];
            return Craft::$app->view->renderTemplate('cookie_consent_banner_' . $classname::templateSlug() . '_cp/' . $classname::settingsModel()::settingsTemplate(),['model' => $classname::settingsModel(), 'canUpdate' => true], View::TEMPLATE_MODE_CP);
        }
    }

    /**
     * @return array
     */
	public function permissions()
	{
		return [
			'activated' => 'cookie-consent:site-settings:activate',
            'cookieName' => 'cookie-consent:site-settings:content',
			'template_class' => 'cookie-consent:site-settings:template',
            'template_settings' => 'cookie-consent:site-settings:template'
		];
	}

    /**
     * @param $attribute
     * @param $params
     */
	public function validatePermission($attribute, $params)
	{
		$attribute_to_permission = $this->permissions();
		if(in_array($attribute, array_keys($this->getDirtyAttributes())) && !Craft::$app->user->checkPermission($attribute_to_permission[$attribute])) {
			$this->addError($attribute, Craft::t('cookie-consent', 'You do not have permission to change this attribute'));
		}
	}

    /**
     * @return mixed
     */
	public function getLastUpdate()
	{
		$dates = [];
		if(isset($this->dateUpdated)) $dates[] = strtotime($this->dateUpdated);
		foreach ($this->getCookieGroups() as $group) if(isset($group->dateUpdated)) $dates[] = strtotime($group->dateUpdated);
		return max($dates);
	}

	/**
	 * Returns the URL to edit this record
	 *
	 * @return int|null|string
	 * @throws NotFoundHttpException
	 */
	public function getEditUrl()
	{
		if($this->site_id) {
			return 'cookie-consent/site/'.$this->getSiteHandleFromId($this->site_id);
		}
		return 'cookie-consent';
	}

	/**
	 * Returns the site’s cookie groups.
	 *
	 * @return ActiveQueryInterface The relational query object.
	 */
	public function getCookieGroups(): ActiveQueryInterface
	{
		return $this->hasMany(CookieGroup::class, ['site_id' => 'site_id'])->orderBy('order, id');
	}

    /**
     * @return array
     */
	public function getRequiredCookieGroups() : array
	{
		$required = [];
		foreach ($this->cookieGroups as $group) if(isset($group->required) && $group->required) $required[] = $group->slug;
		return $required;
	}

    /**
     * @return ActiveQueryInterface
     */
	public function getSite(): ActiveQueryInterface
	{
		return $this->hasOne(Site::class, ['id' => 'site_id']);
	}

	/**
	 * Return a siteHandle from a siteId
	 *
	 * @param string $siteId
	 *
	 * @return int|null
	 * @throws NotFoundHttpException
	 */
	protected function getSiteHandleFromId($siteId)
	{
		if ($siteId !== null) {
			$site = Craft::$app->getSites()->getSiteById($siteId);
			if (!$site) {
				throw new NotFoundHttpException('Invalid site ID: '.$siteId);
			}
			$siteHandle = $site->handle;
		} else {
			$siteHandle = Craft::$app->getSites()->currentSite->handle;
		}

		return $siteHandle;
	}
}
