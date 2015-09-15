<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * InvoicePlane
 *
 * A free and open source web based invoicing system
 *
 * @package		InvoicePlane
 * @author		Kovah (www.kovah.de)
 * @copyright	Copyright (c) 2012 - 2015 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 *
 */

/**
 * pZ: format_currency
 * przygotowuje wygląd kwoty wg ustawień dla rozdzielenia tysięcy i rozdzielenia groszy - dodaje też symbol waluty
 * np.:
 * "12 345,34 zł"  - spacja dla tysięcy, przecinek przed groszami, waluta to 'zł', po spacji (afterspace)
 *
 * @param $amount
 *
 * @return string
 */
function format_currency($amount)
{
    $CI =& get_instance();

    $currency_symbol           = $CI->mdl_settings->setting('currency_symbol'); // np. 'zł'
    $currency_symbol_placement = $CI->mdl_settings->setting('currency_symbol_placement'); // np. 'afterspace'

    if ($currency_symbol_placement == 'before') {
        return $currency_symbol . format_amount($amount);
    } elseif ($currency_symbol_placement == 'afterspace') {
        return format_amount($amount) . "&nbsp;" . $currency_symbol;
    } else {
        return format_amount($amount) . $currency_symbol;
    }
}

/**
 * pZ: format_amount
 * tylko kwota wg ustawień formatu (dla rozdzielenia tysięcy i groszy)
 * np.:
 * "12 345,34"  - spacja dla tysięcy, przecinek przed groszami
 *
 * @param $amount
 *
 * @return null|string
 */
function format_amount($amount)
{
    $CI =& get_instance();

    $amount = floatval($amount);

    $thousands_separator = format_thousands_separator($CI->mdl_settings->setting('thousands_separator')); // np. ' ' (spacja)
    $decimal_point       = $CI->mdl_settings->setting('decimal_point'); // np. ',' (zamiast kropki)

    return number_format($amount, ($decimal_point) ? 2 : 0, $decimal_point, $thousands_separator);
}

function standardize_amount($amount)
{
    $CI =& get_instance();

    $thousands_separator = format_thousands_separator($CI->mdl_settings->setting('thousands_separator'));
    $decimal_point       = $CI->mdl_settings->setting('decimal_point');

    $amount = str_replace($thousands_separator, '', $amount);
    $amount = str_replace($decimal_point, '.', $amount);

    return $amount;
}

function format_thousands_separator($thousands_separator)
{
    return $thousands_separator;

    // pZ: na razie wyłączam
    if (preg_match("/\\s+/", $thousands_separator)) {
        $thousands_separator = "&nbsp;";
    }

    return $thousands_separator;
}

/**
 * pZ: format_round_amount
 *
 * @param $amount
 *
 * @return float|null
 */
function format_round_amount($amount)
{
    $amount_round = floor($amount);

    if ($amount_round == $amount) {
        return $amount_round;
    }

    return format_amount($amount);
}

