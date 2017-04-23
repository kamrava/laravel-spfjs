<?php
namespace Kamrava\LaravelSPF;

use Illuminate\Support\Facades\Facade;

class PartialViewFacade extends Facade {

    protected static function getFacadeAccessor() {
        return 'partialview';
    }

}
