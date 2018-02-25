<?php
declare(strict_types=1);

namespace TMCms\Modules\Rating;

use TMCms\Modules\IModule;
use TMCms\Modules\Rating\Entity\RatingEntity;
use TMCms\Modules\Rating\Entity\RatingEntityRepository;
use TMCms\Orm\Entity;
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
     * @param Entity $client
     * @param int $score
     *
     * @return RatingEntity
     */
    public static function addScore(Entity $item, Entity $client, int $score): RatingEntity
    {
        $rating = new RatingEntity;
        $rating->setItemId($item->getId());
        $rating->setItemType($item->getUnqualifiedShortClassName());
        $rating->setClientId($client->getId());
        $rating->setScore($score);
        $rating->save();

        return $rating;
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

    /**
     * @param Entity $item
     * @param Entity $client
     */
    public static function deleteAllEntriesForItem(Entity $item, Entity $client = null)
    {
        $rating_collection = new RatingEntityRepository;
        $rating_collection->setWhereItemId($item->getId());
        $rating_collection->setWhereItemType($item->getUnqualifiedShortClassName());
        if ($client) {
            $rating_collection->setWhereClientId($client->getId());
        }

        $rating_collection->deleteObjectCollection();
    }

    /**
     * @param Entity $item
     * @param Entity $client
     *
     * @return bool
     */
    public static function checkRatingAlreadyExists(Entity $item, Entity $client): bool
    {
        $rating_collection = new RatingEntityRepository;
        $rating_collection->setWhereItemId($item->getId());
        $rating_collection->setWhereItemType($item->getUnqualifiedShortClassName());
        $rating_collection->setWhereClientId($client->getId());

        return $rating_collection->hasAnyObjectInCollection();
    }
}
