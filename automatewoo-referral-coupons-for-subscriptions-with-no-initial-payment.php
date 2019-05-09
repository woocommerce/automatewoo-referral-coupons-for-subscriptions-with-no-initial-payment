<?php
/*
 * Plugin Name: AutomateWoo - Referral coupons for subscriptions with $0 initial payment
 * Plugin URI: https://github.com/Prospress/automatewoo-referral-coupons-for-subscriptions-with-no-initial-payment/
 * Description: Add support for subscriptions with a $0 initial payment to AutomateWoo referral coupons. The referral coupon is removed after the first subscription payment that is >$0.
 * Author: Prospress Inc.
 * Author URI: https://prospress.com/
 * License: GPLv3
 * Version: 1.0.0
 * Requires at least: 5.1
 * Tested up to: 5.2
 *
 * WC requires at least: 3.6
 *
 * GitHub Plugin URI: Prospress/automatewoo-referral-coupons-for-subscriptions-with-no-initial-payment
 * GitHub Branch: master
 *
 * Copyright 2018 Prospress, Inc.  (email : freedoms@prospress.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package		AutomateWoo - Referral coupons for subscriptions with $0 initial payment
 * @author		Prospress Inc.
 * @since		1.0
 */

namespace Prospress\ARCFSWNIP;

defined( 'ABSPATH' ) || exit;

require_once 'includes/class-pp-dependencies.php';

if ( false === PP_Dependencies::is_woocommerce_active( '3.6' ) ) {
	PP_Dependencies::enqueue_admin_notice( 'AutomateWoo - Referral coupons for subscriptions with $0 initial payment', 'WooCommerce', '3.6' );
	return;
}

if ( false === PP_Dependencies::is_subscriptions_active( '2.4' ) ) {
	PP_Dependencies::enqueue_admin_notice( 'AutomateWoo - Referral coupons for subscriptions with $0 initial payment', 'WooCommerce Subscriptions', '2.4' );
	return;
}

if ( false === PP_Dependencies::is_automatewoo_active( '4.5' ) ) {
	PP_Dependencies::enqueue_admin_notice( 'AutomateWoo - Referral coupons for subscriptions with $0 initial payment', 'AutomateWoo', '4.5' );
	return;
}

if ( false === PP_Dependencies::is_automatewoo_referrals_active( '2.3.2' ) ) {
	PP_Dependencies::enqueue_admin_notice( 'AutomateWoo - Referral coupons for subscriptions with $0 initial payment', 'AutomateWoo - Refer A Friend', '2.3.2' );
	return;
}

require_once 'includes/class-plugin.php';
