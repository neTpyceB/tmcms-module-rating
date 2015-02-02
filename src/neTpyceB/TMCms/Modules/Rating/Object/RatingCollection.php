<?php
namespace neTpyceB\TMCms\Modules\Rating\Object;

use neTpyceB\TMCms\Modules\CommonObjectCollection;

class RatingCollection extends CommonObjectCollection {
    protected $db_table = 'm_rating';

    protected $client_id = 0;
    protected $item_type = '';
    protected $item_id = 0;

    /**
     * @param int $item_id
     * @return $this
     */
    public function setWhereItemId($item_id)
    {
        $this->setFilterValue('item_id', $item_id);

        return $this;

    }

    /**
     * @param int $client_id
     * @return $this
     */
    public function setWhereClientId($client_id)
    {
        $this->setFilterValue('client_id', $client_id);

        return $this;

    }

    /**
     * @param string $item_type
     * @return $this
     */
    public function setWhereItemType($item_type) {
        $this->setFilterValue('item_type', $item_type);

        return $this;
    }
}