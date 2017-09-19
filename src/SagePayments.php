<?php

namespace MidwesternInteractive\LaravelSagePayments;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;

class SagePayments
{
    public function __construct(Repository $configExternal)
    {
        $merchId = $configExternal->get('sagepayments.merchid');
        $merchKey = $configExternal->get('sagepayments.merchkey');
        $devId = $configExternal->get('sagepayments.devid');
        $devKey = $configExternal->get('sagepayments.devkey');
    }

    public function __call($method, $args)
    {
        return call_user_func($method, $args);
    }
}
