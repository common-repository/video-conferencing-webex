<?php

namespace Codemanas\Webex\Core\Helpers;

use DateTime;
use DateTimeZone;
use Exception;

class DateParser {

	private static $defaultTimezone = "America/Los_Angeles";

	private static $defaultFormat = "F j, Y, g:i a";

	/**
	 * This just gives you the date object to play with.
	 *
	 * @param $start_time
	 * @param bool $timezone
	 *
	 * @return DateTime
	 */
	static function getDateObject( $start_time, $timezone = false ): object {
		try {
			$date = new DateTime( $start_time );
			if ( $timezone ) {
				$date->setTimezone( new DateTimeZone( $timezone ) );
			}
		} catch ( Exception $e ) {
			$date = $e->getMessage();
		}

		return $date;
	}

	/**
	 * This is here for just in case use. If you do not prefer auto formatting based on backend data then use this.
	 *
	 * @param $start_time
	 * @param $timezone
	 * @param bool $format
	 *
	 * @return string
	 */
	static function getCustomFormattedDate( $start_time, $format = false, $timezone = false ) {
		$date   = self::getDateObject( $start_time, $timezone );
		$format = ! empty( $format ) ? $format : self::$defaultFormat;

		return $date->format( $format );
	}

	/**
	 * Get hour and minute difference
	 *
	 * @param $start_date
	 * @param $end_date
	 * @param string $type
	 *
	 * @return string
	 */
	static function getHourMinuteDiff( $start_date, $end_date, $type = 'h' ): string {
		try {
			$start = new DateTime( $start_date );
			$end   = new DateTime( $end_date );

			$diff = $start->diff( $end );

			if ( $type == "h" ) {
				return $diff->h;
			} else {
				return $diff->i;
			}

		} catch ( Exception $e ) {
			return $e->getMessage();
		}
	}
}