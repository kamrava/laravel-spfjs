<?php

namespace Kamrava\Laravel_SPF;

use Illuminate\Support\Facades\Facade;

class PartialViewFacade extends Facade {

    protected static function getFacadeAccessor() {
        return 'partialview';
    }

}