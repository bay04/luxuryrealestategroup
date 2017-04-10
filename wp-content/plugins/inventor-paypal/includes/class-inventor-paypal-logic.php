<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require INVENTOR_PAYPAL_DIR . 'libraries/PayPal-PHP-SDK/vendor/autoload.php';

use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

/**
 * Class Inventor_PayPal_Logic
 *
 * @class Inventor_PayPal_Logic
 * @package Inventor_PayPal/Classes
 * @author Pragmatic Mates
 */
class Inventor_PayPal_Logic {
    /**
     * Initialize PayPal functionality
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'process_payment' ), 9999 );
        add_action( 'init', array( __CLASS__, 'process_result' ), 9999 );

	    add_filter( 'inventor_payment_gateways', array( __CLASS__, 'payment_gateways' ) );
    }

	/**
	 * Adds payments gateways
	 *
	 * @access public
	 * @param array $gateways
	 * @return array
	 */
	public static function payment_gateways( $gateways ) {
		if (  self::is_active() ) {
			if ( get_theme_mod( 'inventor_paypal_credit_card', false ) == '1' ) {
				$gateways['paypal-credit-card'] = array(
					'id'      => 'paypal-credit-card',
					'title'   => __( 'PayPal Credit Card', 'inventor-paypal' ),
					'proceed' => true,
					'content' => Inventor_Template_Loader::load( 'paypal/credit-card-form', array(), INVENTOR_PAYPAL_DIR ),
				);
			}

			$gateways['paypal-account'] = array(
				'id'      => 'paypal-account',
				'title'   => __( 'PayPal Account', 'inventor-paypal' ),
				'proceed' => true
			);
		}

		return $gateways;
	}

    /**
     * Process payment form
     *
     * @access public
     * @return void
     */
    public static function process_payment() {
        if ( ! isset( $_POST['process-payment'] ) ) {
            return;
        }

        $gateway = ! empty( $_POST['payment_gateway'] ) ? $_POST['payment_gateway'] : null;

        $settings = array(
            'payment_type'  => ! empty( $_POST['payment_type'] ) ? $_POST['payment_type'] : '',
            'object_id'  	=> ! empty( $_POST['object_id'] ) ? $_POST['object_id'] : '',
            'first_name'    => ! empty( $_POST['first_name'] ) ? $_POST['first_name'] : '',
            'last_name'     => ! empty( $_POST['last_name'] ) ? $_POST['last_name'] : '',
            'card_number'   => ! empty( $_POST['card_number'] ) ? $_POST['card_number'] : '',
            'cvv'           => ! empty( $_POST['cvv'] ) ? $_POST['cvv'] : '',
            'expires_month' => ! empty( $_POST['expires_month'] ) ? $_POST['expires_month'] : '',
            'expires_year'  => ! empty( $_POST['expires_year'] ) ? $_POST['expires_year'] : '',
        );

        // billing details
        $settings['billing_details'] = Inventor_Billing::get_billing_details_from_context( $_POST );

        switch ( $gateway ) {
            case 'paypal-credit-card':
                if ( empty( $_POST['first_name']) ) {
                    Inventor_Utilities::show_message( 'danger', __( 'First name is required.', 'inventor-paypal' ) );
                    break;
                }

                if ( empty( $_POST['last_name']) ) {
                    Inventor_Utilities::show_message( 'danger', __( 'Last name is required.', 'inventor-paypal' ) );
                    break;
                }

                if ( empty( $_POST['card_number']) ) {
                    Inventor_Utilities::show_message( 'danger', __( 'Card number is required.', 'inventor-paypal' ) );
                    break;
                }

                if ( empty( $_POST['cvv']) ) {
                    Inventor_Utilities::show_message( 'danger', __( 'CVV is required.', 'inventor-paypal' ) );
                    break;
                }

                if ( empty( $_POST['expires_month']) ) {
                    Inventor_Utilities::show_message( 'danger', __( 'Expires month is required.', 'inventor-paypal' ) );
                    break;
                }

                if ( empty( $_POST['expires_year']) ) {
                    Inventor_Utilities::show_message( 'danger', __( 'Expires year is required.', 'inventor-paypal' ) );
                    break;
                }

                if ( ! self::validate_card_number( $_POST['card_number'] ) ){
                    Inventor_Utilities::show_message( 'danger', __( 'Credit card number is not valid.', 'inventor-paypal' ) );
                    break;
                }

                if ( ! self::validate_cvv( $_POST['cvv'] ) ){
                    Inventor_Utilities::show_message( 'danger', __( 'CVV number is not valid.', 'inventor-paypal' ) );
                    break;
                }

                $payment = self::process_credit_card( $settings );

                if ( ! empty( $payment->state ) ) {
                    # possible states: ["created", "approved", "completed", "partially_completed", "failed", "canceled", "expired", "in_progress"]
                    if ( in_array( $payment->state, array( 'approved', 'completed' ) ) ) {
                        $url = self::get_paypal_url( true, $gateway, get_current_user_id(), $settings['payment_type'], $settings['object_id'], $settings['billing_details'], $payment->id );
                        wp_redirect( $url );
                        exit();
                    }

                    if ( in_array( $payment->state, array( 'failed', 'canceled', 'expired' ) ) ) {
                        $url = self::get_paypal_url( false, $gateway, get_current_user_id(), $settings['payment_type'], $settings['object_id'], $settings['billing_details'], $payment->id );
                        wp_redirect( $url );
                        exit();
                    }
                } else {
                    $payment_id = empty( $payment->id ) ? null : $payment->id;
                    $url = self::get_paypal_url( false, $gateway, get_current_user_id(), $settings['payment_type'], $settings['object_id'], $settings['billing_details'], $payment_id );
                    wp_redirect($url);
                    exit();
                }

                break;
            case 'paypal-account':
                $url = self::get_account_approval_url( $settings );
                if( ! empty( $url ) ) {
                    wp_redirect( $url );
                    exit();
                }

                break;
        }
    }

    /**
     * Process payment result
     *
     * @access public
     * @return void
     */
    public static function process_result() {
        // check if all required params are set
        $transaction_params = array( 'gateway', 'success', 'user_id', 'payment_type', 'paymentId', 'object_id', 'price', 'currency_code' );

        foreach ( $transaction_params as $required_param ) {
            if ( empty( $_GET[$required_param] ) ) {
                return;
            }
        }

        if ( ! in_array( $_GET['gateway'], array( 'paypal-account', 'paypal-credit-card' ) ) ) {
            return;
        }

        // cast string to bool
        $success = $_GET['success'] == 'true';

        // validate payment
        $is_valid = true;

        if ( $success ) {
            // if paypal param is missing, payment is not valid
            $paypal_params = $_GET['gateway'] == 'paypal-account' ? array( 'paymentId', 'token', 'PayerID' ) : array( 'paymentId' );

            foreach ( $paypal_params as $required_param ) {
                if ( empty( $_GET[$required_param] ) ) {
                    $is_valid = false;
                    break;
                }
            }

            // if params are present, validate them
            if ( $is_valid ) {
                $is_valid = ! Inventor_Post_Type_Transaction::does_transaction_exist( array( 'paypal-account', 'paypal-credit-card' ), $_GET['paymentId'] );
            }

            // if params are present, validate them
            if ( $is_valid ) {
                if ( $_GET['gateway'] == 'paypal-account' ) {
                    $is_valid = self::is_paypal_payment_valid( $_GET['gateway'], $_GET['paymentId'], $_GET['token'], $_GET['PayerID'] );
                } else {
                    $is_valid = self::is_paypal_payment_valid( $_GET['gateway'], $_GET['paymentId'] );
                }
            }

            if ( $_GET['gateway'] == 'paypal-account' ) {
                if ( ! self::execute_payment( $_GET['paymentId'], $_GET['PayerID'] ) ) {
                    $success = false;
                };
            }

            // if payment is invalid, it is not successful transaction
            if ( ! $is_valid ) {
                $success = false;
            }
        }

        // prepare data for transaction
        $params = $_GET;
        foreach ( array( 'success', 'gateway', 'payment_type', 'object_id', 'user_id' ) as $unset_key ) {
            unset( $params[$unset_key] );
        }

        // create transaction
        Inventor_Post_Type_Transaction::create_transaction( $_GET['gateway'], $success, $_GET['user_id'], $_GET['payment_type'], $_GET['paymentId'], $_GET['object_id'], $_GET['price'], $_GET['currency_code'], $params );

        // billing_details
        $billing_details = Inventor_Billing::get_billing_details_from_context( $_GET );

        // hook inventor action
        do_action( 'inventor_payment_processed', $success, $_GET['gateway'], $_GET['payment_type'], $_GET['paymentId'], $_GET['object_id'], $_GET['price'], $_GET['currency_code'], $_GET['user_id'], $billing_details );

        // handle payment
        if ( $success ) {
            if( ! $is_valid ) {
                Inventor_Utilities::show_message( 'danger', __( 'Payment is invalid.', 'inventor-paypal' ) );
            } else if ( ! in_array( $_GET['payment_type'], apply_filters( 'inventor_payment_types', array() ) ) ) {
                Inventor_Utilities::show_message( 'danger', __( 'Undefined payment type.', 'inventor-paypal' ) );
            } else {
                Inventor_Utilities::show_message( 'success', __( 'Payment has been successful.', 'inventor-paypal' ) );
            }
        } else {
            Inventor_Utilities::show_message( 'danger', __( 'Payment failed, canceled or is invalid.', 'inventor-paypal' ) );
        }

        // after payment page
        $redirect_url = Inventor_Utilities::get_after_payment_url( $_GET['payment_type'], $_GET['object_id'] );

        wp_redirect( $redirect_url );
        exit();
    }

    /**
     * Executes PayPal payment
     *
     * @access public
     * @param string $payment_id
     * @param string $payer_id
     * @return bool
     */
    public static function execute_payment( $payment_id, $payer_id ) {
        $api_context = self::get_paypal_context();

        // execution
        $execution = new PaymentExecution();
        $execution->setPayerId( $payer_id );

        // payment
        $payment = Payment::get( $payment_id, $api_context );

        // result
        try {
            $payment->execute($execution, $api_context);
        } catch (Exception $ex) {
            // if execution fails, it is not successful transaction
            return false;
        }

        return true;
    }


    /**
     * Checks if PayPal payment is valid
     *
     * @access public
     * @param string $payment_id
     * @param string $token
     * @param string $payer_id
     * @return bool
     */
    public static function is_paypal_payment_valid( $gateway, $payment_id, $token = null, $payer_id = null) {
        try {
            $api_context = self::get_paypal_context();
            $payment = Payment::get( $payment_id, $api_context );

            if ( $gateway == 'paypal-account' ) {
                $api_payer_id = $payment->payer->payer_info->payer_id;

                if ( $payer_id != $api_payer_id ) {
                    return false;
                }

                $links = $payment->links;
                foreach ( $links as $url ) {
                    if ( $url->rel == 'approval_url' ) {
                        if (strpos( $url->href, 'token=' . $token ) === false) {
                            return false;
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            return false;
        }

        return true;
    }

    /**
     * Gets PayPal context
     *
     * @access public
     * @return Object|bool
     */
    public static function get_paypal_context() {
        $client_id = get_theme_mod( 'inventor_paypal_client_id', null );
        $client_secret = get_theme_mod( 'inventor_paypal_client_secret', null );

        if ( empty( $client_id ) || empty( $client_secret ) ) {
            return false;
        }

        $apiContext = new ApiContext( new OAuthTokenCredential( $client_id, $client_secret ) );

	    $live = get_theme_mod( 'inventor_paypal_live', false );
	    if ( $live == "1" ) {
		    $apiContext->setConfig( array( 'mode' => 'live' ) );
	    } else {
		    $apiContext->setConfig( array( 'mode' => 'sandbox' ) );
	    }

        return $apiContext;
    }

    /**
     * Gets return/success URL
     *
     * @access public
     * @param bool $success
     * @param int $user_id
     * @param string $gateway
     * @param string $payment_type
     * @param int $object_id
     * @param array $billing_details
     * @param string $payment_id
     * @return string
     */
    public static function get_paypal_url( $success, $gateway, $user_id, $payment_type, $object_id, $billing_details, $payment_id = null ) {
        $data = self::get_data( $payment_type, $object_id );

        $success = $success ? 'true' : 'false';

        // get after payment url
        $url = Inventor_Utilities::get_after_payment_url( $payment_type, $object_id );

        $symbol = strpos( $url, '?' ) !== false ? '&' : '?';
        $url = sprintf( '%s%ssuccess=%s', $url, $symbol, $success );

        $params = array(
            'gateway'           => $gateway,
            'payment_type'      => $payment_type,
            'object_id'         => $object_id,
            'user_id'           => $user_id,
            'price'             => $data['price'],
            'currency_code'     => $data['currency_code'],
            'currency_symbol'   => $data['currency_symbol'],
            'price_formatted'   => $data['price_formatted'],
        );

        $params = array_merge( $params, $billing_details );

        foreach( $params as $param => $value ) {
            $url = sprintf( '%s&%s=%s', $url, $param, urlencode( $value ) );
        }

        if ( ! empty( $payment_id ) ) {
            $url = sprintf( '%s&%s=%s', $url, 'paymentId', $payment_id );
        }

        return $url;
    }

    /**
     * Process credit card payment
     *
     * @access public
     * @param array $settings
     * @return Exception|Payment
     */
    public static function process_credit_card( array $settings ) {
        $data = self::get_data( $settings['payment_type'], $settings['object_id'] );

        $card = new CreditCard();
        $card->setType( self::get_credit_card_type( $settings['card_number'] ) )
            ->setNumber( $settings['card_number'] )
            ->setExpireMonth( $settings['expires_month'] )
            ->setExpireYear( $settings['expires_year'] )
            ->setCvv2( $settings['cvv'] )
            ->setFirstName( $settings['first_name'] )
            ->setLastName( $settings['last_name'] );

        $fi = new FundingInstrument();
        $fi->setCreditCard( $card );

        $payer = new Payer();
        $payer->setPaymentMethod( 'credit_card' )
            ->setFundingInstruments( array( $fi ) );

        $item = new Item();
        $item->setName( $data['title'] )
            ->setDescription( $data['description'] )
            ->setCurrency( $data['currency_code'] )
            ->setQuantity( 1 )
            ->setPrice( $data['price'] );

        $item_list = new ItemList();
        $item_list->setItems( array( $item, ) );

        $details = new Details();
        $details->setSubtotal( $data['price'] );

        $amount = new Amount();
        $amount->setCurrency( $data['currency_code'] )
            ->setTotal( $data['price'] )
            ->setDetails( $details );

        $transaction = new Transaction();
        $transaction->setAmount( $amount )
            ->setItemList($item_list)
            ->setDescription( $data['description'] )
            ->setInvoiceNumber( uniqid() );

        $payment = new Payment();
        $payment->setIntent( 'sale' )
            ->setPayer( $payer )
            ->setTransactions( array( $transaction ) );

        try {
            $api_context = self::get_paypal_context();
            $payment->create( $api_context );
            Inventor_Utilities::show_message( 'success', __( 'Payment has been successful.', 'inventor-paypal' ) );

            return $payment;
        } catch (Exception $ex) {
            Inventor_Utilities::show_message( 'danger', __( 'There was an error processing payment.', 'inventor-paypal' ) );
            return $ex;
        }
    }

    /**
     * Gets link for account payment
     *
     * @access public
     * @param array $settings
     * @return string
     */
    public static function get_account_approval_url( array $settings ) {
        $payer = new Payer();
        $payer->setPaymentMethod( 'paypal' );

        $data = self::get_data( $settings['payment_type'], $settings['object_id'] );

        $item = new Item();
        $item->setName( $data['title'] )
            ->setDescription( $data['description'] )
            ->setCurrency( $data['currency_code'] )
            ->setQuantity( 1 )
            ->setPrice( $data['price'] );

        $item_list = new ItemList();
        $item_list->setItems( array($item, ) );

        $details = new Details();
        $details->setSubtotal( $data['price'] );

        $amount = new Amount();
        $amount->setCurrency( $data['currency_code'] )
            ->setTotal( $data['price'] )
            ->setDetails( $details );

        $transaction = new Transaction();
        $transaction->setAmount( $amount )
            ->setItemList( $item_list )
            ->setDescription( $data['description'])
            ->setInvoiceNumber( uniqid() );

        $redirectUrls = new RedirectUrls();
        $return_url = self::get_paypal_url( true, 'paypal-account', get_current_user_id(), $settings['payment_type'], $settings['object_id'], $settings['billing_details'] );
        $cancel_url = self::get_paypal_url( false, 'paypal-account', get_current_user_id(), $settings['payment_type'], $settings['object_id'], $settings['billing_details'] );
        $redirectUrls->setReturnUrl( $return_url )->setCancelUrl( $cancel_url );

        $payment = new Payment();
        $payment->setIntent( 'sale' )
            ->setPayer( $payer )
            ->setRedirectUrls( $redirectUrls )
            ->setTransactions( array( $transaction ) );

        try {
            $api_context = self::get_paypal_context();
            $payment->create( $api_context );
        } catch (Exception $ex) {
            var_dump($ex); die;
            return null;
        }

        return $payment->getApprovalLink();
    }

    /**
     * Prepares payment data
     *
     * @access public
     * @param $payment_type
     * @param $object_id
     * @return array|bool
     */
    public static function get_data( $payment_type, $object_id ) {
        if ( empty( $payment_type ) || empty( $object_id ) ) {
            return false;
        }

        if ( ! in_array( $payment_type, apply_filters( 'inventor_payment_types', array() ) ) ) {
            return false;
        }

        $payment_data = apply_filters( 'inventor_prepare_payment', array(), $payment_type, $object_id );

        $data = array(
            'title'             => $payment_data['action_title'],
            'description'       => $payment_data['description'],
            'price'             => $payment_data['price'],
            'price_formatted'   => Inventor_Price::format_price( $payment_data['price'] ),
            'currency_code'     => Inventor_Price::default_currency_code(),
            'currency_symbol'   => Inventor_Price::default_currency_symbol(),
        );

        return $data;
    }

    /**
     * Checks if PayPal is active
     *
     * @access public
     * @return bool
     */
    public static function is_active() {
        $paypal_client_id = get_theme_mod( 'inventor_paypal_client_id', null );
        $paypal_client_secret = get_theme_mod( 'inventor_paypal_client_secret', null );

        return ( ! empty( $paypal_client_id ) && ! empty( $paypal_client_secret ) );
    }

    /**
     * Validates card number
     *
     * @access public
     * @param $number
     * @return bool
     */
    public static function validate_card_number( $number ) {
        // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
        $number = preg_replace( '/\D/', '', $number );

        // Set the string length and parity
        $number_length = strlen( $number );
        $parity = $number_length % 2;

        // Loop through each digit and do the maths
        $total = 0;
        for ( $i = 0; $i < $number_length; $i++ ) {
            $digit = $number[$i];

            // Multiply alternate digits by two
            if ( $i % 2 == $parity ) {
                $digit *= 2;

                // If the sum is two digits, add them together (in effect)
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            // Total up the digits
            $total += $digit;
        }

        return ( $total % 10 == 0 ) ? true : false;
    }

    /**
     * Validates CVV
     *
     * @access public
     * @param $cvv
     * @return bool
     */
    public static function validate_cvv( $cvv ) {
        return ( strlen( $cvv ) == 3 || strlen( $cvv ) == 4 );
    }

    /**
     * Gets credit card type
     *
     * @access public
     * @param $number
     * @return bool|int|string
     */
    public static function get_credit_card_type( $number ) {
        if ( empty( $number ) ) {
            return false;
        }

        $matchingPatterns = array(
            'visa'          => '/^4[0-9]{12}(?:[0-9]{3})?$/',
            'mastercard'    => '/^5[1-5][0-9]{14}$/',
            'amex'          => '/^3[47][0-9]{13}$/',
            'diners'        => '/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',
            'discover'      => '/^6(?:011|5[0-9]{2})[0-9]{12}$/',
            'jcb'           => '/^(?:2131|1800|35\d{3})\d{11}$/',
        );

        foreach ( $matchingPatterns as $key => $pattern ) {
            if ( preg_match( $pattern, $number ) ) {
                return $key;
            }
        }

        return false;
    }

    /**
     * Returns supported currencies by PayPal listed here:
     *
     * @access public
     * @param string $payment
     * @see https://developer.paypal.com/docs/integration/direct/rest_api_payment_country_currency_support/
     * @return array
     */
    public static function get_supported_currencies( $payment ) {
        if ( $payment == 'account' ) {
            return array( "AUD", "BRL", "CAD", "CZK", "DKK", "EUR", "HKD", "HUF", "ILS", "JPY", "MYR", "MXN", "TWD", "NZD", "NOK", "PHP", "PLN", "GBP", "SGD", "SEK", "CHF", "THB", "TRY", "USD" );
        }

        if ( $payment == 'card' ) {
            return array( "USD", "GBP", "CAD", "EUR", "JPY" );
        }

        return array();
    }
}

Inventor_PayPal_Logic::init();