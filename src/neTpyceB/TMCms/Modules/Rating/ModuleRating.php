<?php
namespace neTpyceB\TMCms\Modules\Rating;

use neTpyceB\TMCms\Modules\IModule;
use neTpyceB\TMCms\Modules\Rating\Object\Rating;
use neTpyceB\TMCms\Modules\Rating\Object\RatingCollection;

defined('INC') or exit;

class ModuleRating implements IModule {
	/** @var $this */
	private static $instance;

	public static $tables = [
		'rating' => 'm_rating'
	];

	public static function getInstance() {
		if (!self::$instance) self::$instance = new self;
		return self::$instance;
	}

	public static function getAverage($item_type, $item_id) {
		$rating_collection = new RatingCollection;
		$rating_collection->setWhereItemId($item_id);
		$rating_collection->setWhereItemType($item_type);
		if (!$rating_collection->hasAnyObjectInCollection()) {
			return 0;
		}

		$sum = 0;
		foreach ($rating_collection->getAsArrayOfObjects() as $rating) {
			/** @var Rating $rating */
			$sum += $rating->getScore();
		}

		return $rating_collection->getCountOfObjectsInCollection() / $sum;
	}
}