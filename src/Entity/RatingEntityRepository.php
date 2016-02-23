<?php

namespace TMCms\Modules\Rating\Entity;

use TMCms\Orm\EntityRepository;

class RatingEntityRepository extends EntityRepository {
    protected $table_structure = [
        'fields' => [
            'client_id' => [
                'type' => 'index',
            ],
            'item_id' => [
                'type' => 'index',
            ],
            'item_type' => [
                'type' => 'varchar',
            ],
            'score' => [
                'type' => 'int',
                'length' => 3,
            ],
        ],
        'indexes' => [
            'item_type' => [
                'type' => 'key',
            ],
        ],
    ];
}