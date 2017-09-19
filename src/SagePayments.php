<?php

namespace MidwesternInteractive\LaravelSagePayments;

use Illuminate\Config\Repository;

class SagePayments
{
    public function __construct(Repository $configExternal)
    {
        $merchId = $configExternal->get('sagepayments.merchid');
        $merchKey = $configExternal->get('sagepayments.merchkey');
        $devId = $configExternal->get('sagepayments.devid');
        $devKey = $configExternal->get('sagepayments.devkey');
    }
}
