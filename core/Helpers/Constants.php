<?php

namespace Codemanas\Webex\Core\Helpers;

final class Constants {
	const POST_TYPE = 'webex-events';
	const TAXONOMY = 'webex-taxonomy';

	/**
	 * Throw an exception if tried to instantiate.
	 * @throws \Exception
	 */
	private function __construct() {
		// throw an exception if someone can get in here (I'm paranoid)
		throw new \Exception( "Can't get an instance of Constants" );
	}
}