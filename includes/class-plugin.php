<?php

namespace Prospress\ARCFSWNIP;

use AutomateWoo\Referrals;

defined( 'ABSPATH' ) || exit;

/**
 * Class Plugin
 * @package Prospress\ARCFSWNIP
 */
final class Plugin {

	/**
	 * Init this mini-plugin.
	 */
	public static function init() {
		add_filter( 'automatewoo/referrals/coupon_data', [ __CLASS__, 'filter_referral_coupon_data' ] );
		add_action( 'woocommerce_subscription_renewal_payment_complete', [ __CLASS__, 'remove_referral_coupon_after_subscription_payment' ] );
	}

	/**
	 * Make referral coupons recurring coupons so they can be used on free trial and synced subscriptions.
	 *
	 * @param array $coupon_data
	 *
	 * @return array
	 */
	public static function filter_referral_coupon_data( $coupon_data ) {

		// set coupon type to either a fixed or percentage recurring discount
		switch ( AW_Referrals()->options()->offer_type ) {
			case 'coupon_discount':
				$coupon_data['discount_type'] = 'recurring_fee';
				break;

			case 'coupon_percentage_discount':
				$coupon_data['discount_type'] = 'recurring_percent';
				break;
		}

		return $coupon_data;
	}

	/**
	 * Remove the referral coupon after the first subscription renewal payment.
	 *
	 * NOTE: We can safely remove the coupon here and the referral can be created because the advocate is stored on the parent order.
	 * NOTE: We aren't using the in-built subscription coupon limit feature for a couple of reasons.
	 *       Primarily so that we are catching ALL referral coupons even coupons that have been expired.
	 *
	 * @param \WC_Subscription $subscription
	 */
	public static function remove_referral_coupon_after_subscription_payment( $subscription ) {
		$referral_coupon = null;

		foreach ( $subscription->get_used_coupons() as $coupon_code ) {
			// If coupon code matches referral coupon pattern and isn't a stored coupon
			if ( Referrals\Coupons::matches_referral_coupon_pattern( $coupon_code ) && 0 === wc_get_coupon_id_by_code( $coupon_code ) ) {
				$referral_coupon = $coupon_code;
				break;
			}
		}

		if ( $referral_coupon ) {
			$subscription->remove_coupon( $referral_coupon );
			$subscription->add_order_note( sprintf( 'Referral coupon (%1$s) was removed because there was a successful renewal payment.', $referral_coupon ) );
		}
	}

}

Plugin::init();
