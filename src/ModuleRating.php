<?php

namespace TMCms\Modules\Rating;

use TMCms\Modules\IModule;
use TMCms\Modules\Rating\Entity\RatingEntity;
use TMCms\Modules\Rating\Entity\RatingEntityRepository;
use TMCms\Orm\Entity;
use TMCms\Strings\Converter;
use TMCms\Traits\singletonInstanceTrait;

defined('INC') or exit;

class ModuleRating implements IModule {
	use singletonInstanceTrait;

	public static $tables = [
		'rating' => 'm_ratings'
	];

	/**
	 *
	 * @param Entity $item
	 * @param int $client_id
	 * @param int $score
	 * @return int
	 */
	public static function addScore(Entity $item, $client_id, $score) {
		$rating = self::checkScoreExists($item, $client_id);

		if (!$rating) {
			$rating = new RatingEntity;
			$rating->setItemId($item->getId());
			$rating->setItemType(Converter::classWithNamespaceToUnqualifiedShort($item));
			$rating->setClientId($client_id);
			$rating->setScore($score);
			$rating->save();
		}

		return $rating->getId();
	}

	/**
	 * @param Entity $item
	 * @param int $client_id
	 * @return RatingEntityRepository
	 */
	public static function checkScoreExists(Entity $item, $client_id) {
		$rating_collection = new RatingEntityRepository;
		$rating_collection->setWhereItemId($item->getId());
		$rating_collection->setWhereItemType(Converter::classWithNamespaceToUnqualifiedShort($item));
		$rating_collection->setWhereClientId($client_id);

		return $rating_collection->getFirstObjectFromCollection();
	}

	/**
	 * @param Entity $item
	 * @return float
     */
	public static function getAverage(Entity $item) {
		$rating_collection = new RatingEntityRepository;
		$rating_collection->setWhereItemId($item->getId());
		$rating_collection->setWhereItemType(Converter::classWithNamespaceToUnqualifiedShort($item));
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