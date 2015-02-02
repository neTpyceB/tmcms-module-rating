<?php
namespace neTpyceB\TMCms\Modules\Rating\Object;

use neTpyceB\TMCms\Modules\CommonObject;
use neTpyceB\TMCms\Strings\Converter;

/**
 * Class Product
 * @method getScore() string
 */
class Rating extends CommonObject {
    protected $db_table = 'm_rating';

    protected $client_id = 0;
    protected $item_type = '';
    protected $item_id = 0;
    protected $score = 0;
}