<div class="filter filter-posts filter-events">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1><?php _e( 'Kalender', 'mufa' ); ?></h1>
                <div class="filter-items">
                    <form action="<?php the_permalink(); ?>" method="get">
                        <div class="filter-item filter-item-select">
                            <select name="event-type">
                                <?php echo \Beck\Mufa\Event::get_type_options( get_query_var( 'event-type' ), __( 'Alle Veranstaltungen', 'mufa' ) ); ?>
                            </select>
                        </div>
                        <div class="filter-item filter-item-select">
                            <select name="event-year">
                                <?php echo \Beck\Mufa\Event::get_year_options( get_query_var( 'event-year' ), __( 'Alle Jahre', 'mufa' ) ); ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php return; ?>

<div class="filter filter-posts filter-events">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1><?php _e( 'Kalender', 'mufa' ); ?></h1>
                <div class="filter-items">
                    <div class="filter-item filter-item-select">
                        <form action="<?php the_permalink(); ?>" method="get">
                            <select name="event-type">
								<?php echo \Beck\Mufa\Event::get_type_options( get_query_var( 'event-type' ), __( 'Alle Veranstaltungen', 'mufa' ) ); ?>
                            </select>
                        </form>
                    </div>
                    <div class="filter-item filter-item-select">
                        <form action="<?php the_permalink(); ?>" method="get">
                            <select name="event-year">
								<?php echo \Beck\Mufa\Event::get_year_options( get_query_var( 'event-year' ), __( 'Alle Jahre', 'mufa' ) ); ?>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>