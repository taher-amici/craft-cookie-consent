<?php

namespace elleracompany\cookieconsent\events;

use elleracompany\cookieconsent\interfaces\BannerInterface;
use yii\base\Event;
use craft\web\View;
use craft\events\RegisterTemplateRootsEvent;
use elleracompany\cookieconsent\CookieConsent;

class RegisterBannerTemplatesEvent extends Event
{

    public function addClass(string $classname)
    {
        /** @var $class BannerInterface */
        $class = new $classname;
        Event::on(
            View::class,
            View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) use ($class) {
                $event->roots['_craft_cookie_consent_'.$class::templateSlug()] = $class::settingsModel()::twigPath();
            }
        );
        CookieConsent::getInstance()->addBannerTemplate($classname);
    }
}