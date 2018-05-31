<?php
/**
 * Number Helper.
 *
 * Methods to make numbers more readable.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Helper
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace lib\Cake\View\Helper;



/**
 * Number helper library.
 *
 * Methods to make numbers more readable.
 *
 * @package       Cake.View.Helper
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/number.html
 * @see Number
 */
class NumberHelper extends AppHelper {

/**
 * Number instance
 *
 * @var Number
 */
	protected $_engine = null;

/**
 * Default Constructor
 *
 * ### Settings:
 *
 * - `engine` Class name to use to replace Number functionality
 *            The class needs to be placed in the `Utility` directory.
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper
 * @throws \Exception When the engine class could not be found.
 */
	public function __construct(View $View, $settings = array()) {
		$settings = Hash::merge(array('engine' => 'Number'), $settings);
		parent::__construct($View, $settings);
		list($plugin, $engineClass) = pluginSplit($settings['engine'], true);
		/* TODO: App::uses($engineClass, $plugin . 'Utility'); */
		if (class_exists($engineClass)) {
			$this->_engine = new $engineClass($settings);
		} else {
			throw new \Exception(__d('cake_dev', '{0} could not be found', $engineClass));
		}
	}

/**
 * Call methods from Number utility class
 */
	public function __call($method, $params) {
		return call_user_func_array(array($this->_engine, $method), $params);
	}

/**
 * @see: Number::precision()
 *
 * @param float $number	A floating point number.
 * @param integer $precision The precision of the returned number.
 * @return float Formatted float.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/number.html#NumberHelper::precision
 */
	public function precision($number, $precision = 3) {
		return $this->_engine->precision($number, $precision);
	}

/**
 * @see: Number::toReadableSize()
 *
 * @param integer $size Size in bytes
 * @return string Human readable size
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/number.html#NumberHelper::toReadableSize
 */
	public function toReadableSize($size) {
		return $this->_engine->toReadableSize($size);
	}

/**
 * @see: Number::toPercentage()
 *
 * @param float $number A floating point number
 * @param integer $precision The precision of the returned number
 * @return string Percentage string
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/number.html#NumberHelper::toPercentage
 */
	public function toPercentage($number, $precision = 2) {
		return $this->_engine->toPercentage($number, $precision);
	}

/**
 * @see: Number::format()
 *
 * @param float $number A floating point number
 * @param integer $options if int then places, if string then before, if (,.-) then use it
 *   or array with places and before keys
 * @return string formatted number
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/number.html#NumberHelper::format
 */
	public function format($number, $options = false) {
		return $this->_engine->format($number, $options);
	}

/**
 * @see: Number::currency()
 *
 * @param float $number
 * @param string $currency Shortcut to default options. Valid values are 'USD', 'EUR', 'GBP', otherwise
 *   set at least 'before' and 'after' options.
 * @param array $options
 * @return string Number formatted as a currency.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/number.html#NumberHelper::currency
 */
	public function currency($number, $currency = 'USD', $options = array()) {
		return $this->_engine->currency($number, $currency, $options);
	}

/**
 * @see: Number::addFormat()
 *
 * @param string $formatName The format name to be used in the future.
 * @param array $options The array of options for this format.
 * @return void
 * @see NumberHelper::currency()
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/number.html#NumberHelper::addFormat
 */
	public function addFormat($formatName, $options) {
		return $this->_engine->addFormat($formatName, $options);
	}

}
