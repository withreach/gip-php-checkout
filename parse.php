<?php namespace GoInterpay;
// ===========================================================================
// Copyright 2016-2017 GoInterpay
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//    http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
// ===========================================================================
//
// Parsing helpers.  These are used to check values as input from the user
// before being send in a request.  Please feel free to use any of these
// methods to extract data from responses.
//
class parse {

  // Used for argument checking.
  const NullOk = true;

  // =========================================================================
  // Simple Type Parsers and Helpers
  // =========================================================================

  // -------------------------------------------------------------------------
  // Get an optional value from an array.
  //
  public static function optional($array, $key)
  {
    return isset($array[$key]) ? $array[$key] : null;
  }

  // -------------------------------------------------------------------------
  // Get a required value from an array.
  //
  public static function required($array, $key)
  {
    if(isset($array[$key]) === false) throw new Missing($key);
    return $array[$key];
  }

  // -------------------------------------------------------------------------
  // Returns the value iff it is a boolean.
  //
  public static function as_boolean($x, $nullOk = false)
  {
    if(is_null($x) && $nullOk) return null;
    if(is_bool($x)) return $x;
    throw new InvalidValue($x, 'boolean');
  }

  // -------------------------------------------------------------------------
  // Extract a required boolean from an array.
  //
  public static function get_boolean($array, $key)
  { return parse::as_boolean(parse::required($array, $key)); }

  // -------------------------------------------------------------------------
  // Extract a boolean from an array.  If not present or null, return null.
  //
  public static function optional_boolean($array, $key)
  { return parse::as_boolean(parse::optional($array, $key), parse::NullOk); }


  // -------------------------------------------------------------------------
  // Returns the value iff it is a string.
  //
  public static function as_string($x, $nullOk = false)
  {
    if(is_null($x) && $nullOk) return null;
    if(is_string($x)) return $x;
    throw new InvalidValue($x, 'string');
  }

  // -------------------------------------------------------------------------
  // Extract a required string from an array.
  //
  public static function get_string($array, $key)
  { return parse::as_string(parse::required($array, $key)); }

  // -------------------------------------------------------------------------
  // Extract a string from an array.  If not present or null, return null.
  //
  public static function optional_string($array, $key)
  { return parse::as_string(parse::optional($array, $key), parse::NullOk); }


  // -------------------------------------------------------------------------
  // Returns the value iff it is a decimal string.
  //
  public static function as_decimal($x, $nullOk = false)
  {
    if(is_null($x) && $nullOk) return null;
    if(is_string($x) && preg_match('/^[0-9]+(?:.[0-9]*)?$/', $x))
      return $x;
    throw new InvalidValue($x, 'decimal value');
  }

  // -------------------------------------------------------------------------
  // Extract a required decimal value from an array.
  //
  public static function get_decimal($array, $key)
  { return parse::as_decimal(parse::required($array, $key)); }

  // -------------------------------------------------------------------------
  // Extract a decimal from an array.  If not present or null, return null.
  //
  public static function optional_decimal($array, $key)
  { return parse::as_decimal(parse::optional($array, $key), parse::NullOk); }


  // -------------------------------------------------------------------------
  // Returns the value iff it is a number string.
  //
  public static function as_number($x, $nullOk = false)
  {
    if(is_null($x) && $nullOk) return null;
    if(is_string($x) && preg_match('/^[0-9]+$/', $x)) return $x;
    throw new InvalidValue($x, 'number');
  }

  // -------------------------------------------------------------------------
  // Extract a required number value from an array.
  //
  public static function get_number($array, $key)
  { return parse::as_number(parse::required($array, $key)); }

  // -------------------------------------------------------------------------
  // Extract a number from an array.  If not present or null, return null.
  //
  public static function optional_number($array, $key)
  { return parse::as_number(parse::optional($array, $key), parse::NullOk); }


  // -------------------------------------------------------------------------
  // Returns the value iff it is a URL.
  //
  public static function as_url($x, $nullOk = false)
  {
    if(is_null($x) && $nullOk) return null;
    if(filter_var($x, FILTER_VALIDATE_URL)) return $x;
    throw new InvalidValue($x, 'URL');
  }

  // -------------------------------------------------------------------------
  // Extract a required URL from an array.
  //
  public static function get_url($array, $key)
  { return parse::as_url(parse::required($array, $key)); }

  // -------------------------------------------------------------------------
  // Extract a URL from an array.  If not present or null, return null.
  //
  public static function optional_url($array, $key)
  { return parse::as_url(parse::optional($array, $key), parse::NullOk); }


  // -------------------------------------------------------------------------
  // Returns the value iff it is a country.
  //
  public static function as_country($x, $nullOk = false)
  {
    if(is_null($x) && $nullOk) return null;
    if(preg_match('/^[A-Z]{2}$/', $x)) return $x;
    throw new InvalidValue($x, 'ISO 3166-1-alpha-2 country code');
  }

  // -------------------------------------------------------------------------
  // Extract a required country from an array.
  //
  public static function get_country($array, $key)
  { return parse::as_country(parse::required($array, $key)); }

  // -------------------------------------------------------------------------
  // Extract a country from an array.  If not present or null, return null.
  //
  public static function optional_country($array, $key)
  { return parse::as_country(parse::optional($array, $key), parse::NullOk); }


  // -------------------------------------------------------------------------
  // Returns the value iif it is a UUID.
  //
  public static function as_uuid($x, $nullOk = false)
  {
    if(is_null($x) && $nullOk) return null;
    if(preg_match('/^[A-F0-9]{8}-(?:[A-F0-9]{4}-){3}[A-F0-9]{12}$/i', $x))
      return $x;
    throw new InvalidValue($x, 'UUID');
  }

  // -------------------------------------------------------------------------
  // Extract a required UUID from an array.
  //
  public static function get_uuid($array, $key)
  { return parse::as_uuid(parse::required($array, $key)); }

  // -------------------------------------------------------------------------
  // Extract a UUID from an array.  If not present or null, return null.
  //
  public static function optional_uuid($array, $key)
  { return parse::as_uuid(parse::optional($array, $key), parse::NullOk); }


  // -------------------------------------------------------------------------
  // Returns the value iif it is a date.
  //
  public static function as_date($x, $nullOk = false)
  {
    if(is_null($x) && $nullOk) return null;
    if(preg_match('/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/', $x))
      return $x;
    throw new InvalidValue($x, 'date');
  }

  // -------------------------------------------------------------------------
  // Extract a required date from an array.
  //
  public static function get_date($array, $key)
  { return parse::as_date(parse::required($array, $key)); }

  // -------------------------------------------------------------------------
  // Extract a date from an array.  If not present or null, return null.
  //
  public static function optional_date($array, $key)
  { return parse::as_date(parse::optional($array, $key), parse::NullOk); }


  // -------------------------------------------------------------------------
  // Returns the value iif it is a currency.
  //
  public static function as_currency($x, $nullOk = false)
  {
    if(is_null($x) && $nullOk) return null;
    if(preg_match('/^[A-Z]{3}$/', $x)) return $x;
    throw new InvalidValue($x, 'ISO 4217 currency code');
  }

  // -------------------------------------------------------------------------
  // Extract a required currency from an array.
  //
  public static function get_currency($array, $key)
  { return parse::as_currency(parse::required($array, $key)); }

  // -------------------------------------------------------------------------
  // Extract a currency from an array.  If not present or null, return null.
  //
  public static function optional_currency($array, $key)
  { return parse::as_currency(parse::optional($array, $key), parse::NullOk); }


  // -------------------------------------------------------------------------
  // Returns the value iif it is an email address.
  //
  public static function as_email($x, $nullOk = false)
  {
    if(is_null($x) && $nullOk) return null;
    if(filter_var($x, FILTER_VALIDATE_EMAIL)) return $x;
    throw new InvalidValue($x, 'email address');
  }

  // -------------------------------------------------------------------------
  // Extract a required email address from an array.
  //
  public static function get_email($array, $key)
  { return parse::as_email(parse::required($array, $key)); }

  // -------------------------------------------------------------------------
  // Extract an email address from an array.  If not present or null, return
  // null.
  //
  public static function optional_email($array, $key)
  { return parse::as_email(parse::optional($array, $key), parse::NullOk); }


  // -------------------------------------------------------------------------
  // Returns the value iif it is an IP address.
  //
  public static function as_ip($x, $nullOk = false)
  {
    $common_flags = FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE;
    if(is_null($x) && $nullOk) return null;
    if(filter_var($x, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | $common_flags) ||
       filter_var($x, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | $common_flags))
      return $x;
    throw new InvalidValue($x, '/ public IP address');
  }

  // -------------------------------------------------------------------------
  // Extract a required IP address from an array.
  //
  public static function get_ip($array, $key)
  { return parse::as_ip(parse::required($array, $key)); }

  // -------------------------------------------------------------------------
  // Extract an IP address from an array.  If not present or null, return null.
  //
  public static function optional_ip($array, $key)
  { return parse::as_ip(parse::optional($array, $key), parse::NullOk); }


  // =========================================================================
  // Complex Type Parsers
  // =========================================================================

  // -------------------------------------------------------------------------
  // Get all of the items.  There must be at least one.
  // 
  // Must be specified as:
  //   'Items' => [
  //     [
  //       'Sku' => '123X',
  //       'ConsumerPrice' => '123.45',
  //       'Quantity' => 1.0,
  //       'Description' => 'widget', // optional
  //       'ImageUrl' => 'http://example.com/widget.png' // optional
  //     ],
  //     ...
  //   ]
  //
  public static function get_items($array, $nullOk = false)
  {
    $x = parse::optional($array, 'Items');
    if(is_null($x)){
      if($nullOk) return null;
      throw new InvalidValue($x, 'array for Items');
    }
    if(is_array($x) === false) throw new InvalidValue($x, 'array for Items');
    $items = [];
    foreach($x as $y){
      if(is_null($y)){
        throw new InvalidValue($x, 'array value for Items');
      }
      if(is_array($y) === false){
        throw new InvalidValue($x, 'array for Items entry');
      }
      array_push($items,
                 parse::filter([
                   'Sku' => parse::get_string($y, 'Sku'),
                   'ConsumerPrice' => parse::get_decimal($y, 'ConsumerPrice'),
                   'Quantity' => parse::get_decimal($y, 'Quantity'),
                   'Description' => parse::optional_string($y, 'Description'),
                   'ImageUrl' => parse::optional_url($y, 'ImageUrl')
                 ]));
    }
    return $items;
  }

  // -------------------------------------------------------------------------
  // Get the shipping details, if any.
  //
  // Must be specified as:
  //   'Shipping' => [
  //     'ConsumerPrice' => '10.23',
  //     'ConsumerTaxes' => '4.56',
  //     'ConsumerDuty' => '3.90'
  //   ]
  //
  public static function get_shipping($array)
  {
    $x = parse::optional($array, 'Shipping');
    if(is_null($x)) return null;
    if(is_array($x) === false){
      throw new InvalidValue($x, 'array for Shipping');
    }
    return
      parse::filter([
        'ConsumerPrice' => parse::get_decimal($x, 'ConsumerPrice'),
        'ConsumerTaxes' => parse::get_decimal($x, 'ConsumerTaxes'),
        'ConsumerDuty' => parse::get_decimal($x, 'ConsumerDuty')
      ]);
  }

  // -------------------------------------------------------------------------
  // Get any ancillary charges or discounts, if any.
  // 
  // Must be specified as:
  //   'Charges' / 'Discounts' => [
  //     [
  //       'Name' => 'random charge',
  //       'ConsumerPrice' => 1.00
  //     ],
  //     ...
  //   ]
  //
  public static function get_ancillary($array, $name)
  {
    $x = parse::optional($array, $name);
    if(is_null($x)) return null;
    if(is_array($x) === false){
      throw new InvalidValue($x, 'array for ' . $name);
    }
    $values = [];
    foreach($x as $y){
      if(is_null($y)){
        throw new InvalidValue($x, 'array value for ' . $name);
      }
      if(is_array($y) === false){
        throw new InvalidValue($x, 'array for ' . $name . ' entry');
      }
      array_push($values,
                 [
                   'Name' => parse::get_string($y, 'Name'),
                   'ConsumerPrice' => parse::get_string($y, 'ConsumerPrice')
                 ]);
    }
    return $values;
  }

  // -------------------------------------------------------------------------
  // Get details about financing, if any.
  //
  // Must be specified as:
  //   'Financing' => [
  //     'Instalments' => 3,
  //     'ConsumerPrice' => 10.00
  //   ]
  //
  public static function get_financing($array)
  {
    $x = parse::optional($array, 'Financing');
    if(is_null($x)) return null;
    if(is_array($x) === false){
      throw new InvalidValue($x, 'array for Financing');
    }
    return
      [
        'Instalments' => parse::get_number($x, 'Instalments'),
        'ConsumerPrice' => parse::get_decimal($x, 'ConsumerPrice')
      ];
  }

  // -------------------------------------------------------------------------
  // Get the values of a Consumer.  Please see the API documentation for
  // details.
  //
  public static function get_consumer($array, $nullOk=false)
  {
    $x = parse::optional($array, 'Consumer');
    if(is_null($x) && $nullOk) return null;
    if(is_array($x) === false){
      throw new InvalidValue($x, 'array for Consumer');
    }
    $contact = parse::get_contact($x, true);
    return array_merge($contact, parse::filter([
      'NationalIdentifier' => parse::optional_string($x, 'NationalIdentifier'),
      'BirthDate' => parse::optional_date($x, 'BirthDate'),
      'MerchantProfileId' => parse::optional_string($x, 'MerchantProfileId'),
      'IpAddress' => parse::optional_ip($x, 'IpAddress')
    ]));
  }

  // -------------------------------------------------------------------------
  // Get the values of a Consignee, if any.  Please see the API documentation
  // for details.
  //
  public static function get_consignee($array, $nullOk)
  {
    $x = parse::optional($array, 'Consignee');
    if(is_null($x) && $nullOk) return null;
    return parse::get_contact($x, false);
  }

  // -------------------------------------------------------------------------
  // shared values for consumer and consignee
  //
  private static function get_contact($x, $isConsumer)
  {
    if(is_array($x) === false){
      throw new InvalidValue($x, 'array for ' .
                             ($isConsumer ? 'Consumer' : 'Consignee'));
    }
    return
      parse::filter([
        'Name' => parse::get_string($x, 'Name'),
        'Company' => parse::optional_string($x, 'Company'),
        'Email' => ($isConsumer
                    ? parse::get_string($x, 'Email')
                    : parse::optional_string($x, 'Email')),
        'Phone' => ($isConsumer
                    ? parse::get_string($x, 'Phone')
                    : parse::optional_string($x, 'Phone')),
        'Address' => parse::get_string($x, 'Address'),
        'City' => parse::get_string($x, 'City'),
        'Region' => parse::optional_string($x, 'Region'),
        'PostalCode' => parse::optional_string($x, 'PostalCode'),
        'Country' => parse::get_country($x, 'Country')
      ]);
  }

  // -------------------------------------------------------------------------
  // Get the values of a card used for a payment attempt.
  // 
  // $x must be specified as:
  //   [
  //     'Number' => '4111111111111111',
  //     'Name' => 'Joe Shopper',
  //     'Expiry' => ['Year' => 2020, 'Month' => 5],
  //     'VerificationCode' => '013'
  //   ]
  //
  public static function get_card($x, $nullOk = false)
  {
    if(is_null($x) && $nullOk) return null;
    if(is_array($x) === false){
      throw new InvalidValue($x, 'array for card');
    }

    // GOTCHA: we can't use the convenience parsers for the number and cvv
    // because it will log/throw the card number and/or cvv.
    $number = parse::required($x, 'Number');
    if(is_null($number) || preg_match('/^[0-9]+$/', $number) === false){
      throw new InvalidValue('REDACTED', 'card number');
    }

    $cvv = parse::required($x, 'VerificationCode');
    if(is_null($cvv) || preg_match('/^[0-9]+$/', $cvv) === false){
      throw new InvalidValue('REDACTED', 'verification code');
    }

    $exp = parse::required($x, 'Expiry');
    if(is_array($exp) === false){
      throw new InvalidValue($x, 'array for card expiry');
    }

    $month = parse::get_number($exp, 'Month');
    if($month < 0 || $month > 12){
      throw new InvalidValue($month, 'Month');
    }

    return
      [
        'Number' => $number,
        'Name' => parse::get_string($x, 'Name'),
        'Expiry' => [
          'Month' => $month,
          'Year' => parse::get_number($exp, 'Year')
        ],
        'VerificationCode' => $cvv
      ];
  }

  // -------------------------------------------------------------------------
  // Helper function to remove null values, but keep all other values in the
  // output.
  //
  public static function filter($x)
  {
    return array_filter($x, function($v){ return $v !== null; });
  }
}

// ==========================================================================
?>
