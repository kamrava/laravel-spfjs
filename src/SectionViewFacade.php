<?php
namespace Kamrava\Spf;

use Illuminate\Support\Facades\Facade;

class SectionViewFacade extends Facade {

    protected static function getFacadeAccessor() {
        return 'sectionview';
    }

}
