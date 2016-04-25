<?php

namespace Quiubas;

class Keywords extends Base {
	/**
	 * @param string Base path
	 */
	public static $base = 'keywords';

	/**
	 * @param string Action path
	 */
	public static $action = 'keywords/{id}';

	/**
	 * @param array $params Parameters
	 */
	public static function create( $params ) {
		return parent::action( $params );
	}
}

