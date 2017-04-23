<?php
namespace Kamrava\SPF;

use Illuminate\Support\Facades\Facade;

class PartialViewFacade extends Facade {

    protected static function getFacadeAccessor() {
        return 'partialview';
    }

}
