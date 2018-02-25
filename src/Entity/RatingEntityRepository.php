<?php
declare(strict_types=1);

namespace TMCms\Modules\Rating\Entity;

use TMCms\Orm\EntityRepository;
use TMCms\Orm\TableStructure;

/**
 * Class RatingEntityRepository
 * @package TMCms\Modules\Rating\Entity
 *
 * @method $this setWhereClientId(int $client_id)
 * @method $this setWhereItemId(int $item_id)
 * @method $this setWhereItemType(string $item_type)
 */
class RatingEntityRepository extends EntityRepository {
    protected $table_structure = [
        'fields' => [
            'client_id' => [
                'type' => TableStructure::FIELD_TYPE_INDEX,
            ],
            'item_id' => [
                'type' => TableStructure::FIELD_TYPE_INDEX,
            ],
            'item_type' => [
                'type' => TableStructure::FIELD_TYPE_VARCHAR_255,
            ],
            'score' => [
                'type' => TableStructure::FIELD_TYPE_UNSIGNED_INTEGER,
            ],
        ],
    ];
}
