<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$title       = $params['title'];
$subtitle    = $params['subtitle'];
$domain      = '//www.booking.com/';
$target_page = 'searchresults.html';

$destination             = $params['destination'];
$aid                     = $params['aid'];
$placeholder_destination = $params['placeholder_destination'];
$placeholder_checkin     = $params['placeholder_checkin'];
$placeholder_checkout    = $params['placeholder_checkout'];
$submit                  = $params['submit'];

$action = $domain . $target_page;

//$action = '//www.booking.com/hotel/vn/cherry-sapa.html';

wp_enqueue_script( 'jquery-ui-datepicker' );
wp_enqueue_script( 'bcsb-main' );
wp_enqueue_style( 'bcsb-main' );
wp_enqueue_style( 'bcsb-font' );
wp_enqueue_style( 'jquery-ui', BCSB_URL . 'assets/css/jquery-ui.css' );
?>

<div class="bcsb-searchbox <?php echo esc_attr( $params['layout'] ) ?>  <?php echo esc_attr( $params['el_class'] ) ?>">

	<?php if ( $title ) : ?>
        <h3 class="title-box"><?php echo esc_html( $title ); ?></h3>
	<?php endif; ?>
	<?php if ( $subtitle ) : ?>
        <div class="sub-title"><?php echo esc_html( $subtitle ); ?></div>
	<?php endif; ?>
    <form action="<?php echo esc_url( $action ); ?>" method="get" target="_blank">
        <div class="fieldset">

            <input type="hidden" name="si" value="ai,co,ci,re,di"/>
            <input type="hidden" value="on" name="do_availability_check"/>
            <input type="hidden" value="0" name="group_children"/>

			<?php
			if ( $aid ) {
				echo '<input type="hidden" name="aid" value="' . $aid . '" />';
				echo '<input type="hidden" name="error_url" value="' . $action . '?aid=' . $aid . ';" />';
			} elseif ( ! empty( $cname ) ) {
				echo '<input type="hidden" name="ifl" value="1" />';
				echo '<input type="hidden" name="error_url" value="' . $action . '" />';
			}
			?>


            <div class="input-field-wrap field-destination">
                <div class="input-field">
                    <input type="text" name="ss" value="<?php echo esc_attr( $destination ); ?>"
                           placeholder="<?php echo esc_attr( $placeholder_destination ); ?>" required/>
                    <span class="bcsb-icon-bed"></span>
                </div>


            </div>

            <div class="input-field-wrap field-dates">
                <div class="dates-wrap">
                    <div class="input-field">
                        <input type="text" name="checkin" value="" class="bcsb-datepicker checkin"
                               autocomplete="off" placeholder="<?php echo esc_attr( $placeholder_checkin ); ?>"
                               required/>
                        <input type="hidden" name="checkin_monthday">
                        <input type="hidden" name="checkin_year_month">
                    </div>

                    <div class="input-field">
                        <input type="text" name="checkout" value="" class="bcsb-datepicker checkout"
                               autocomplete="off" placeholder="<?php echo esc_attr( $placeholder_checkout ); ?>"
                               required/>
                        <input type="hidden" name="checkout_monthday">
                        <input type="hidden" name="checkout_year_month">
                    </div>
                </div>
            </div>

            <div class="input-field-wrap field-guests">
                <div class="guests-wrap">
                    <div class="input-field">
                        <i class="bcsb-icon-person"></i>
                        <select name="no_rooms">
							<?php
							for ( $i = 1; $i <= 30; $i ++ ) {
								echo '<option value="' . $i . '">' . sprintf( esc_html( _n( '%d room', '%d rooms', $i, 'bcsb' ) ), $i ) . '</option>';
							}
							?>
                        </select>
                    </div>
                    <div class="input-field">
                        <select name="group_adults">
							<?php
							for ( $i = 1; $i <= 30; $i ++ ) {
								echo '<option value="' . $i . '">' . sprintf( esc_html( _n( '%d adult', '%d adults', $i, 'bcsb' ) ), $i ) . '</option>';
							}
							?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="input-field-wrap field-button">
                <input class="btn btn-primary" type="submit" value="<?php echo esc_attr( $submit ); ?>"/>
            </div>

        </div>

        <div class="form-footer">
            <div class="travel-purpose">
                <input class="ui-checkbox-input" type="checkbox" value="business" id="sb_travel_purpose_checkbox"
                       name="sb_travel_purpose">
                <label class="ui-checkbox-label"
                       for="sb_travel_purpose_checkbox"><?php esc_html_e( 'I\'m travelling for work', 'bcsb' ) ?></label>
            </div>
            <div class="powered-by">
                <img src="<?php echo BCSB_URL . 'assets/images/booking-com.png'; ?>" alt="Powered by Booking.com">
            </div>
        </div>

    </form>

</div>