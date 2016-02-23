<?php

namespace TMCms\Modules\Rating;

use TMCms\Modules\IModule;
use TMCms\Modules\Rating\Entity\RatingEntity;
use TMCms\Modules\Rating\entity\RatingEntityRepository;
use TMCms\Traits\singletonInstanceTrait;

defined('INC') or exit;

class ModuleRating implements IModule {
	use singletonInstanceTrait;

	public static $tables = [
		'rating' => 'm_ratings'
	];

	/**
	 * @param int $item_type
	 * @param int $item_id
	 * @param int $client_id
	 * @return int
	 */
	public static function addScore($item_type, $item_id, $client_id) {
		$score = self::checkScoreExists($item_type, $item_id, $client_id);

		if (!$score) {
			$score = new RatingEntity;
			$score->setItemId($item_id);
			$score->setItemType($item_type);
			$score->setClientId($client_id);
			$score->save();
		}

		return $score->getId();
	}

	/**
	 * @param int $item_type
	 * @param int $item_id
	 * @param int $client_id
	 * @return RatingEntityRepository
	 */
	public static function checkScoreExists($item_type, $item_id, $client_id) {
		$rating_collection = new RatingEntityRepository;
		$rating_collection->setWhereItemId($item_id);
		$rating_collection->setWhereItemType($item_type);
		$rating_collection->setWhereClientId($client_id);

		return $rating_collection->getFirstObjectFromCollection();
	}

	public static function getAverage($item_type, $item_id) {
		$rating_collection = new RatingEntityRepository;
		$rating_collection->setWhereItemId($item_id);
		$rating_collection->setWhereItemType($item_type);
		$rating_collection->addSimpleSelectFields(['id', 'score']);

		$sum = 0;
		foreach ($rating_collection->getAsArrayOfObjectData() as $rating) {
			$sum += $rating['score'];
		}

		if ($sum == 0) {
			return 0;
		}

		return round($rating_collection->getCountOfObjectsInCollection() / $sum, 2);
	}
}