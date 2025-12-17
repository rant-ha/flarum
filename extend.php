<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use Flarum\Extend;

return [
    (new Extend\Frontend('forum'))
        ->css(__DIR__.'/resources/less/custom.less'),
    
    (new Extend\Frontend('admin'))
        ->css(__DIR__.'/resources/less/custom.less'),
    

];
