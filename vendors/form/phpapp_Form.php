<?php

/**
 * @author: Cody Agent
 */
if ( ! class_exists( 'phpapp_Form' ) ) {
	class phpapp_Form {
		public static function createForm( $action = '', $method = '', $htmlOptions = array() ) {
			$form = "<form action='$action' method='$method'";
			foreach ( $htmlOptions as $key => $option ) {
				$form .= " '.$key.'='$option'";
			}
			$form .= '/>';

			return $form;
		}

		public static function endForm() {
			return '</form>';
		}

		public static function textField( $name, $value, $htmlOptions = array() ) {
			$field = "<input type='text' name='$name' value='$value'";
			foreach ( $htmlOptions as $key => $option ) {
				$field .= ' ' . $key . '="' . $option . '"';
			}
			$field .= '/>';

			return $field;
		}

		public static function passWordField( $name, $value, $htmlOptions = array() ) {
			$field = "<input type='password' name='$name' value='$value'";
			foreach ( $htmlOptions as $key => $option ) {
				$field .= ' ' . $key . '="' . $option . '"';
			}
			$field .= '/>';

			return $field;
		}

		public static function hiddenField( $name, $value, $htmlOptions = array() ) {
			$field = "<input type='hidden' name='$name' value='$value'";
			foreach ( $htmlOptions as $key => $option ) {
				$field .= ' ' . $key . '="' . $option . '"';
			}
			$field .= '/>';

			return $field;
		}

		public static function dropDownList( $name, $selected = array(), $data = array(), $htmlOptions = array() ) {
			if ( $selected == null ) {
				$selected = array();
			}

			//filter the selected
			$selected = array_filter( $selected, 'strlen' );
			$field = "<select name='$name'";
			foreach ( $htmlOptions as $key => $option ) {
				$field .= ' ' . $key . '="' . $option . '"';
			}
			$field .= '/>';
			//option go here
			if ( isset( $htmlOptions['prompt'] ) ) {
				$field .= '<option value="">' . $htmlOptions['prompt'] . '</option>';
			}
			foreach ( (array) $data as $key => $value ) {
				$optionSelect = in_array( $key, $selected ) ? 'selected="selected"' : null;
				$field .= "<option $optionSelect value=\"$key\">$value</option>";
			}
			$field .= '</select>';

			return $field;
		}

		public static function textArea( $name, $value, $htmlOptions = array() ) {
			$field = '<textarea name="' . $name . '"';
			foreach ( $htmlOptions as $key => $option ) {
				$field .= ' ' . $key . '="' . $option . '"';
			}
			$field .= '>' . $value . '</textarea>';

			return $field;
		}

		public static function checkBox( $name, $isCheck, $htmlOptions = array() ) {
			$field = '<input name="' . $name . '" type="checkbox"';
			foreach ( $htmlOptions as $key => $option ) {
				$field .= ' ' . $key . '="' . $option . '"';
			}
			if ( $isCheck == true ) {
				$field .= 'checked="checked"';
			}
			$field .= '/>';

			return $field;
		}

		public static function countryDropdown( $name, $selected = array(), $htmlOptions = array() ) {
			$countries = array(
				''   => 'Please select a country',
				'AD' => 'Andorra',
				'AE' => 'United Arab Emirates',
				'AF' => 'Afghanistan',
				'AG' => 'Antigua &amp; Barbuda',
				'AI' => 'Anguilla',
				'AL' => 'Albania',
				'AM' => 'Armenia',
				'AN' => 'Netherlands Antilles',
				'AO' => 'Angola',
				'AQ' => 'Antarctica',
				'AR' => 'Argentina',
				'AS' => 'American Samoa',
				'AT' => 'Austria',
				'AU' => 'Australia',
				'AW' => 'Aruba',
				'AZ' => 'Azerbaijan',
				'BA' => 'Bosnia and Herzegovina',
				'BB' => 'Barbados',
				'BD' => 'Bangladesh',
				'BE' => 'Belgium',
				'BF' => 'Burkina Faso',
				'BG' => 'Bulgaria',
				'BH' => 'Bahrain',
				'BI' => 'Burundi',
				'BJ' => 'Benin',
				'BM' => 'Bermuda',
				'BN' => 'Brunei Darussalam',
				'BO' => 'Bolivia',
				'BR' => 'Brazil',
				'BS' => 'Bahama',
				'BT' => 'Bhutan',
				'BU' => 'Burma (no longer exists)',
				'BV' => 'Bouvet Island',
				'BW' => 'Botswana',
				'BY' => 'Belarus',
				'BZ' => 'Belize',
				'CA' => 'Canada',
				'CC' => 'Cocos (Keeling) Islands',
				'CF' => 'Central African Republic',
				'CG' => 'Congo',
				'CH' => 'Switzerland',
				'CI' => 'Côte D\'ivoire (Ivory Coast)',
				'CK' => 'Cook Iislands',
				'CL' => 'Chile',
				'CM' => 'Cameroon',
				'CN' => 'China',
				'CO' => 'Colombia',
				'CR' => 'Costa Rica',
				'CS' => 'Czreturnslovakia (no longer exists)',
				'CU' => 'Cuba',
				'CV' => 'Cape Verde',
				'CX' => 'Christmas Island',
				'CY' => 'Cyprus',
				'CZ' => 'Czech Republic',
				'DD' => 'German Democratic Republic (no longer exists)',
				'DE' => 'Germany',
				'DJ' => 'Djibouti',
				'DK' => 'Denmark',
				'DM' => 'Dominica',
				'DO' => 'Dominican Republic',
				'DZ' => 'Algeria',
				'EC' => 'Ecuador',
				'EE' => 'Estonia',
				'EG' => 'Egypt',
				'EH' => 'Western Sahara',
				'ER' => 'Eritrea',
				'ES' => 'Spain',
				'ET' => 'Ethiopia',
				'FI' => 'Finland',
				'FJ' => 'Fiji',
				'FK' => 'Falkland Islands (Malvinas)',
				'FM' => 'Micronesia',
				'FO' => 'Faroe Islands',
				'FR' => 'France',
				'FX' => 'France, Metropolitan',
				'GA' => 'Gabon',
				'GB' => 'United Kingdom (Great Britain)',
				'GD' => 'Grenada',
				'GE' => 'Georgia',
				'GF' => 'French Guiana',
				'GH' => 'Ghana',
				'GI' => 'Gibraltar',
				'GL' => 'Greenland',
				'GM' => 'Gambia',
				'GN' => 'Guinea',
				'GP' => 'Guadeloupe',
				'GQ' => 'Equatorial Guinea',
				'GR' => 'Greece',
				'GS' => 'South Georgia and the South Sandwich Islands',
				'GT' => 'Guatemala',
				'GU' => 'Guam',
				'GW' => 'Guinea-Bissau',
				'GY' => 'Guyana',
				'HK' => 'Hong Kong',
				'HM' => 'Heard &amp; McDonald Islands',
				'HN' => 'Honduras',
				'HR' => 'Croatia',
				'HT' => 'Haiti',
				'HU' => 'Hungary',
				'ID' => 'Indonesia',
				'IE' => 'Ireland',
				'IL' => 'Israel',
				'IN' => 'India',
				'IO' => 'British Indian Ocean Territory',
				'IQ' => 'Iraq',
				'IR' => 'Islamic Republic of Iran',
				'IS' => 'Iceland',
				'IT' => 'Italy',
				'JM' => 'Jamaica',
				'JO' => 'Jordan',
				'JP' => 'Japan',
				'KE' => 'Kenya',
				'KG' => 'Kyrgyzstan',
				'KH' => 'Cambodia',
				'KI' => 'Kiribati',
				'KM' => 'Comoros',
				'KN' => 'St. Kitts and Nevis',
				'KP' => 'Korea, Democratic People\'s Republic of',
				'KR' => 'Korea, Republic of',
				'KW' => 'Kuwait',
				'KY' => 'Cayman Islands',
				'KZ' => 'Kazakhstan',
				'LA' => 'Lao People\'s Democratic Republic',
				'LB' => 'Lebanon',
				'LC' => 'Saint Lucia',
				'LI' => 'Liechtenstein',
				'LK' => 'Sri Lanka',
				'LR' => 'Liberia',
				'LS' => 'Lesotho',
				'LT' => 'Lithuania',
				'LU' => 'Luxembourg',
				'LV' => 'Latvia',
				'LY' => 'Libyan Arab Jamahiriya',
				'MA' => 'Morocco',
				'MC' => 'Monaco',
				'MD' => 'Moldova, Republic of',
				'MG' => 'Madagascar',
				'MH' => 'Marshall Islands',
				'ML' => 'Mali',
				'MN' => 'Mongolia',
				'MM' => 'Myanmar',
				'MO' => 'Macau',
				'MP' => 'Northern Mariana Islands',
				'MQ' => 'Martinique',
				'MR' => 'Mauritania',
				'MS' => 'Monserrat',
				'MT' => 'Malta',
				'MU' => 'Mauritius',
				'MV' => 'Maldives',
				'MW' => 'Malawi',
				'MX' => 'Mexico',
				'MY' => 'Malaysia',
				'MZ' => 'Mozambique',
				'NA' => 'Namibia',
				'NC' => 'New Caledonia',
				'NE' => 'Niger',
				'NF' => 'Norfolk Island',
				'NG' => 'Nigeria',
				'NI' => 'Nicaragua',
				'NL' => 'Netherlands',
				'NO' => 'Norway',
				'NP' => 'Nepal',
				'NR' => 'Nauru',
				'NT' => 'Neutral Zone (no longer exists)',
				'NU' => 'Niue',
				'NZ' => 'New Zealand',
				'OM' => 'Oman',
				'PA' => 'Panama',
				'PE' => 'Peru',
				'PF' => 'French Polynesia',
				'PG' => 'Papua New Guinea',
				'PH' => 'Philippines',
				'PK' => 'Pakistan',
				'PL' => 'Poland',
				'PM' => 'St. Pierre &amp; Miquelon',
				'PN' => 'Pitcairn',
				'PR' => 'Puerto Rico',
				'PT' => 'Portugal',
				'PW' => 'Palau',
				'PY' => 'Paraguay',
				'QA' => 'Qatar',
				'RE' => 'Réunion',
				'RO' => 'Romania',
				'RU' => 'Russian Federation',
				'RW' => 'Rwanda',
				'SA' => 'Saudi Arabia',
				'SB' => 'Solomon Islands',
				'SC' => 'Seychelles',
				'SD' => 'Sudan',
				'SE' => 'Sweden',
				'SG' => 'Singapore',
				'SH' => 'St. Helena',
				'SI' => 'Slovenia',
				'SJ' => 'Svalbard &amp; Jan Mayen Islands',
				'SK' => 'Slovakia',
				'SL' => 'Sierra Leone',
				'SM' => 'San Marino',
				'SN' => 'Senegal',
				'SO' => 'Somalia',
				'SR' => 'Suriname',
				'ST' => 'Sao Tome &amp; Principe',
				'SU' => 'Union of Soviet Socialist Republics (no longer exists)',
				'SV' => 'El Salvador',
				'SY' => 'Syrian Arab Republic',
				'SZ' => 'Swaziland',
				'TC' => 'Turks &amp; Caicos Islands',
				'TD' => 'Chad',
				'TF' => 'French Southern Territories',
				'TG' => 'Togo',
				'TH' => 'Thailand',
				'TJ' => 'Tajikistan',
				'TK' => 'Tokelau',
				'TM' => 'Turkmenistan',
				'TN' => 'Tunisia',
				'TO' => 'Tonga',
				'TP' => 'East Timor',
				'TR' => 'Turkey',
				'TT' => 'Trinidad &amp; Tobago',
				'TV' => 'Tuvalu',
				'TW' => 'Taiwan, Province of China',
				'TZ' => 'Tanzania, United Republic of',
				'UA' => 'Ukraine',
				'UG' => 'Uganda',
				'UM' => 'United States Minor Outlying Islands',
				'US' => 'United States of America',
				'UY' => 'Uruguay',
				'UZ' => 'Uzbekistan',
				'VA' => 'Vatican City State (Holy See)',
				'VC' => 'St. Vincent &amp; the Grenadines',
				'VE' => 'Venezuela',
				'VG' => 'British Virgin Islands',
				'VI' => 'United States Virgin Islands',
				'VN' => 'Viet Nam',
				'VU' => 'Vanuatu',
				'WF' => 'Wallis &amp; Futuna Islands',
				'WS' => 'Samoa',
				'YD' => 'Democratic Yemen (no longer exists)',
				'YE' => 'Yemen',
				'YT' => 'Mayotte',
				'YU' => 'Yugoslavia',
				'ZA' => 'South Africa',
				'ZM' => 'Zambia',
				'ZR' => 'Zaire',
				'ZW' => 'Zimbabwe'
			);

			self::dropDownList( $name, $selected, $countries, $htmlOptions );
		}
	}
}