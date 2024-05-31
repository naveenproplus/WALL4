<?php
namespace App\helper;
class NumberToWord	{
	public static function NumToText($Number){ 
		return self::toText($Number)." Only";
	}
	private static function toText($amt) {
		if (is_numeric($amt)) {
			$sign = $amt > 0 ? '' : 'Negative ';
			return $sign .self::toQuadrillions(abs($amt));
		}else {
			throw new Exception('Only numeric values are allowed.');
		}
	}
	private static function toOnes($amt) {
		$words = array(
			0 => 'Zero',
			1 => 'One',
			2 => 'Two',
			3 => 'Three',
			4 => 'Four',
			5 => 'Five',
			6 => 'Six',
			7 => 'Seven',
			8 => 'Eight',
			9 => 'Nine'
		);
	 
		if ($amt >= 0 && $amt < 10){
			return $words[$amt];
		}else{
			throw new ArrayIndexOutOfBoundsException('Array Index not defined');
		}
	}
	private  static function toTens($amt) { // handles 10 - 99
		$firstDigit = intval($amt / 10);
		$remainder = $amt % 10;
	 
		if ($firstDigit == 1) {
			$words = array(
				0 => 'Ten',
				1 => 'Eleven',
				2 => 'Twelve',
				3 => 'Thirteen',
				4 => 'Fourteen',
				5 => 'Fifteen',
				6 => 'Sixteen',
				7 => 'Seventeen',
				8 => 'Eighteen',
				9 => 'Nineteen'
			);
			return $words[$remainder];
		} else if ($firstDigit >= 2 && $firstDigit <= 9) {
			$words = array(
				2 => 'Twenty',
				3 => 'Thirty',
				4 => 'Fourty',
				5 => 'Fifty',
				6 => 'Sixty',
				7 => 'Seventy',
				8 => 'Eighty',
				9 => 'Ninety'
			);
			$rest = $remainder == 0 ? '' : self::toOnes($remainder);
			return $words[$firstDigit] . ' ' . $rest;
		}else{
			return self::toOnes($amt);
		}
	}
	private static function toHundreds($amt) {
		$ones = intval($amt / 100);
		$remainder = $amt % 100;
	 
		if ($ones >= 1 && $ones < 10) {
			$rest = $remainder == 0 ? '' : self::toTens($remainder);
			return self::toOnes($ones) . ' Hundred ' . $rest;
		}else{
			return self::toTens($amt);
		}
	}
	private static function toThousands($amt) {
		$hundreds = intval($amt / 1000);
		$remainder = $amt % 1000;
	
		if ($hundreds >= 1 && $hundreds < 1000) {
			$rest = $remainder == 0 ? '' : self::toHundreds($remainder);
			return self::toHundreds($hundreds) . ' Thousand ' . $rest;
		}else{
			return self::toHundreds($amt);
		}
	}
	private static function toMillions($amt) {
		$hundreds = intval($amt / pow(1000, 2));
		$remainder = $amt % pow(1000, 2);
	
		if ($hundreds >= 1 && $hundreds < 1000) {
			$rest = $remainder == 0 ? '' : self::toThousands($remainder);
			return self::toHundreds($hundreds) . ' Million ' . $rest;
		}else{
			return self::toThousands($amt);
		}			
	}
	private static function  toBillions($amt) {
		$hundreds = intval($amt / pow(1000, 3));
		$remainder = $amt - $hundreds * pow(1000, 3);
		if ($hundreds >= 1 && $hundreds < 1000) {
			$rest = $remainder == 0 ? '' : self::toMillions($remainder);
			return self::toHundreds($hundreds) . ' Billion ' . $rest;
		}else{
			return self::toMillions($amt);
		}
	}
	private static function  toTrillions($amt) {
		$hundreds = intval($amt / pow(1000, 4));
		$remainder = $amt - $hundreds * pow(1000, 4);
		if ($hundreds >= 1 && $hundreds < 1000) {
			$rest = $remainder == 0 ? '' : self::toBillions($remainder);
			return self::toHundreds($hundreds) . ' Trillion ' . $rest;
		}else{
			return self::toBillions($amt);
		}
	}
	private static function  toQuadrillions($amt) {
		$hundreds = intval($amt / pow(1000, 5));
		$remainder = $amt - $hundreds * pow(1000, 5);
 		if ($hundreds >= 1 && $hundreds < 1000) {
			$rest = $remainder == 0 ? '' : self::toTrillions($remainder);
			return self::toHundreds($hundreds) . ' Quadrillion ' . $rest;
		}else{
			return self::toTrillions($amt);
		}
	}
}