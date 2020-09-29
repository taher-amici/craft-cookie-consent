<?php

namespace elleracompany\cookieconsent\events;

use elleracompany\cookieconsent\CookieConsent;
use yii\base\Event;

class RegisterBannerTemplatesEvent extends Event
{

    public function addClass(string $class)
    {
        CookieConsent::getInstance()->addBannerTemplate($class);
    }
}