<?php

namespace Quiubas;

class SMS extends Base {
	/**
	 * @param string Base path
	 */
	public static $base = 'sms';

	/**
	 * @param string Action path
	 */
	public static $action = 'sms/{id}';

	/**
	 * @param array $params Parameters
	 */
	public static function send( $params ) {
		return parent::action( $params );
	}

	/**
	 * @param string $id ID
	 * @param array $params Parameters
	 */
	public static function getResponses( $id, $params = array() ) {
		return \Quiubas\Network::get( array( static::$action . '/responses', array( 'id' => $id ) ), $params );
	}
}

