<?php
declare(strict_types=1);

namespace TMCms\Modules\Rating;

use TMCms\Modules\IModule;
use TMCms\Modules\Rating\Entity\RatingEntity;
use TMCms\Modules\Rating\Entity\RatingEntityRepository;
use TMCms\Orm\Entity;
use TMCms\Strings\Converter;
use TMCms\Traits\singletonInstanceTrait;

\defined('INC') or exit;

/**
 * Class ModuleRating
 * @package TMCms\Modules\Rating
 */
class ModuleRating implements IModule {
    use singletonInstanceTrait;

    /**
     *
     * @param Entity $item
     * @param int $client_id
     * @param int $score
     * @return int
     */
    public static function addScore(Entity $item, $client_id, $score): int
    {
        $rating = self::checkScoreExists($item, $client_id);

        if (!$rating) {
            $rating = new RatingEntity;
            $rating->setItemId($item->getId());
            $rating->setItemType(Converter::classWithNamespaceToUnqualifiedShort($item));
            $rating->setClientId($client_id);
            $rating->setScore($score);
            $rating->save();
        }

        return (int)$rating->getId();
    }

    /**
     * @param Entity $item
     * @param int $client_id
     *
     * @return bool
     */
    public static function checkScoreExists(Entity $item, $client_id): bool
    {
        $rating_collection = new RatingEntityRepository;
        $rating_collection->setWhereItemId($item->getId());
        $rating_collection->setWhereItemType(Converter::classWithNamespaceToUnqualifiedShort($item));
        $rating_collection->setWhereClientId($client_id);

        return $rating_collection->hasAnyObjectInCollection();
    }

    /**
     * @param Entity $item
     *
     * @return float
     */
    public static function getAverage(Entity $item): float
    {
        return (float)q_value('SELECT AVG(`score`) FROM `'. (new RatingEntityRepository)->getDbTableName() .'` WHERE `item_id` = "'. (int)$item->getId() .'" and `item_type` = "'. sql_prepare($item->getUnqualifiedShortClassName()) .'"');
    }
}
