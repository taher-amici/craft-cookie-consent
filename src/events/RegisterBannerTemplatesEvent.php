<?php

namespace elleracompany\cookieconsent\events;

use yii\base\Event;
use craft\web\View;
use craft\events\RegisterTemplateRootsEvent;
use elleracompany\cookieconsent\CookieConsent;
use elleracompany\cookieconsent\interfaces\BannerInterface;

class RegisterBannerTemplatesEvent extends Event
{

    public function addClass(string $classname)
    {
        /** @var $classname BannerInterface */

        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, function (RegisterTemplateRootsEvent $e) use ($classname) {
            $e->roots['cookie_consent_banner_' . $classname::templateSlug() . '_cp'] = $classname::cpTemplatePath();
        });

        Event::on(View::class, View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS, function (RegisterTemplateRootsEvent $e) use ($classname) {
            $e->roots['cookie_consent_banner_' . $classname::templateSlug() . '_site'] = $classname::siteTemplatePath();
        });

        CookieConsent::getInstance()->addBannerTemplate($classname);
    }
}