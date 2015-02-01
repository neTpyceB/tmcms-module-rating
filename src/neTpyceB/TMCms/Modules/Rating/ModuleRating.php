<?php
namespace neTpyceB\TMCms\Modules\Rating;

use neTpyceB\TMCms\Modules\IModule;

defined('INC') or exit;

class ModuleRating implements IModule {
	/** @var $this */
	private static $instance;

	public static function getInstance() {
		if (!self::$instance) self::$instance = new self;
		return self::$instance;
	}



}