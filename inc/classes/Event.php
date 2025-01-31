<?php

namespace Beck\Mufa;

class Event {

	const ICAL_EVENT_LENGTH_MIN = 120;

	public static function init_hooks() {
		self::add_save_post_hook();
	}

	public static function add_save_post_hook() {
		add_action( 'acf/save_post', [ self::class, 'on_save_post' ], 10 );
	}

	public static function remove_save_post_hook() {
		remove_action( 'acf/save_post', [ self::class, 'on_save_post' ], 10 );
	}

	public static function on_save_post( $post_id ) {
		if (
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
			wp_is_post_revision( $post_id ) ||
			get_post_meta( $post_id, 'orig_event_id' ) ||
			get_post_type( $post_id ) != 'mufa_event'
		) {
			return;
		}

		$dates = [];
		foreach ( get_field( 'dates' ) as $date ) {
			$dates[] = date( 'Y', $date['date_time'] );
		}
		$dates = array_unique( $dates );
		sort( $dates, SORT_NUMERIC );

		delete_post_meta( $post_id, 'event_years' );
		foreach ( $dates as $date ) {
			add_post_meta( $post_id, 'event_years', $date );
		}
	}

	public static function get_upcoming_events( $limit = 40, $no_recurrences = false ) {
		$query_args = [
			'post_type'        => 'mufa_event',
			'meta_query'       => [
				'relation' => 'OR',
				[
					'key'   => 'event_years',
					'value' => date( 'Y' )
				],
				[
					'key'   => 'event_years',
					'value' => (string) intval( date( 'Y' ) + 1 )
				]
			],
			'suppress_filters' => false
		];

		$events = self::get_events( $query_args );

		// remove old events
		$timestamp = time();
		$events    = array_filter( $events, function ( $event ) use ( $timestamp ) {
			return $event['date']['date_time'] >= $timestamp;
		} );

		if ( $no_recurrences ) {
			$unique_events     = [];
			$existing_post_ids = [];

			foreach ( $events as $event ) {
				if ( ! in_array( $event['post']->ID, $existing_post_ids ) ) {
					$unique_events[]     = $event;
					$existing_post_ids[] = $event['post']->ID;
				}
			}

			$events = $unique_events;
		}

		$events = array_slice( $events, 0, $limit );

		return $events;
	}

	public static function get_events_by_year( $year ) {
		$query_args = [
			'post_type'  => 'mufa_event',
			'meta_query' => [
				[
					'key'   => 'event_years',
					'value' => $year
				]
			]
		];

		$events = self::get_events( $query_args );

		$events = array_filter( $events, function ( $event ) use ( $year ) {
			return date( 'Y', $event['date']['date_time'] ) == $year;
		} );

		return $events;
	}

	public static function get_events_by_type( $type ) {
		$query_args = [
			'post_type' => 'mufa_event',
			'tax_query' => [
				[
					'taxonomy' => 'mufa_event_type',
					'field'    => 'slug',
					'terms'    => $type
				]
			]
		];

		$events = self::get_events( $query_args, true );

		return $events;
	}

	public static function get_events_by_filters( $type, $year ) {
		$query_args = [
			'post_type' => 'mufa_event'
		];

		if ( $type ) {
			$query_args['tax_query'] = [
				[
					'taxonomy' => 'mufa_event_type',
					'field'    => 'slug',
					'terms'    => $type
				]
			];
		}

		if ( $year ) {
			$query_args['meta_query'] = [
				[
					'key'   => 'event_years',
					'value' => $year
				]
			];
		}

		$events = self::get_events( $query_args, true );

		if ( $year ) {
			$events = array_filter( $events, function ( $event ) use ( $year ) {
				return date( 'Y', $event['date']['date_time'] ) == $year;
			} );
		}

		return $events;
	}

	public static function get_events( $query_args, $order_desc = false ) {
		$query_args['suppress_filters'] = false;
		$query_args['posts_per_page']   = - 1;

		$query = new \WP_Query( $query_args );

		$events = [];
		foreach ( $query->get_posts() as $post ) {
			foreach ( get_field( 'dates', $post ) as $date ) {
				$events[] = [
					'date' => $date,
					'post' => $post
				];
			}
		}

		usort( $events, function ( $event_a, $event_b ) use ( $order_desc ) {
			if ( $order_desc ) {
				return $event_b['date']['date_time'] <=> $event_a['date']['date_time'];
			} else {
				return $event_a['date']['date_time'] <=> $event_b['date']['date_time'];
			}
		} );

		wp_reset_postdata();

		return $events;
	}

	public static function get_event_years() {
		global $wpdb;

		$years = $wpdb->get_results( "
			SELECT DISTINCT meta_value
			FROM $wpdb->postmeta
			WHERE meta_key LIKE 'event_years'
			AND meta_value NOT LIKE ''
			ORDER BY meta_value DESC
		", ARRAY_N );

		return $years;
	}

	public static function get_year_options( $selected_value, $default_label ) {
		$options       = [];
		$has_selection = false;

		foreach ( self::get_event_years() as $event_year ) {
			if ( $event_year[0] == $selected_value ) {
				$selected      = 'selected';
				$has_selection = true;
			} else {
				$selected = '';
			}

			$options[] = sprintf(
				'<option value="%s" %s>%s</option>',
				$event_year[0],
				$selected,
				$event_year[0]
			);
		}

		$html = sprintf(
			'<option value="" %s>%s</option>',
			$has_selection ? '' : 'selected',
			$default_label
		);

		$html .= implode( '', $options );

		return $html;
	}

	public static function get_type_options( $selected_value, $default_label ) {
		$options       = [];
		$has_selection = false;

		$terms = get_terms( [
			'taxonomy' => 'mufa_event_type'
		] );

		foreach ( $terms as $term ) {
			if ( $term->slug == $selected_value ) {
				$selected      = 'selected';
				$has_selection = true;
			} else {
				$selected = '';
			}

			$options[] = sprintf(
				'<option value="%s" %s>%s</option>',
				$term->slug,
				$selected,
				esc_html( $term->name )
			);
		}

		$html = sprintf(
			'<option value="" %s>%s</option>',
			$has_selection ? '' : 'selected',
			$default_label
		);

		$html .= implode( '', $options );

		return $html;
	}

	public static function generate_ical_data( $event, $date_time ) {
		$dtstamp = self::ical_date( );
		$dtstart = self::ical_date( $date_time );
		$dtend   = self::ical_date( $date_time, sprintf( 'PT%dM', self::ICAL_EVENT_LENGTH_MIN ) );
		$summary = $event->post_title;

		$eol = "\r\n";

		$content =
			"BEGIN:VCALENDAR" . $eol .
			"VERSION:2.0" . $eol .
			"PRODID:-//hacksw/handcal//NONSGML v1.0//EN" . $eol .
			"BEGIN:VEVENT" . $eol .
			"UID:" . $event->ID . "-" . md5( $date_time ) . "@musikfabrik.eu" . $eol .
			"DTSTAMP:" . $dtstamp . $eol .
			"DTSTART:" . $dtstart . $eol .
			"DTEND:" . $dtend . $eol .
			"SUMMARY:" . $summary . $eol .
			"END:VEVENT" . $eol .
			"END:VCALENDAR";

		return $content;
	}

	public static function render_ical_download( $event, $timestamp ) {
		header( 'Content-type: text/calendar; charset=utf-8' );
		header( 'Content-Disposition: inline; filename=musikfabrik.ics' );

		echo self::generate_ical_data( $event, $timestamp );

		exit();
	}

	public static function ical_date( $date_time = null, $add = null ) {
		$dt = new \DateTime( $date_time ?: 'now', new \DateTimeZone( 'Europe/Berlin' ) );
		$dt->setTimezone( new \DateTimeZone( 'UTC' ) );

		if ( $add ) {
			$dt->add( new \DateInterval( $add ) );
		}

		return $dt->format( 'Ymd\THis\Z' );

		// return gmdate( 'Ymd', $timestamp ) . 'T' . gmdate( 'His', $timestamp ) . 'Z';
	}

	public static function format_dt( $format, $date_time ) {
		$dt = new \DateTime( $date_time );
		return $dt->format( $format );
	}
}