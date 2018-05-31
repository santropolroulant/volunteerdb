<?php
/**
 * CakeEmailTest file
 *
 * PHP 5
 *
 * CakePHP(tm) Tests <http://book.cakephp.org/2.0/en/development/testing.html>
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://book.cakephp.org/2.0/en/development/testing.html CakePHP(tm) Tests
 * @package       Cake.Test.Case.Network.Email
 * @since         CakePHP(tm) v 2.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace lib\Cake\Test\Case\Network\Email;


/**
 * Help to test Email
 *
 */
class TestCakeEmail extends Email {

/**
 * Config
 *
 */
	protected $_config = array();

/**
 * Wrap to protected method
 *
 */
	public function formatAddress($address) {
		return parent::_formatAddress($address);
	}

/**
 * Wrap to protected method
 *
 */
	public function wrap($text) {
		return parent::_wrap($text);
	}

/**
 * Get the boundary attribute
 *
 * @return string
 */
	public function getBoundary() {
		return $this->_boundary;
	}

/**
 * Encode to protected method
 *
 */
	public function encode($text) {
		return $this->_encode($text);
	}

}

/*
 * EmailConfig class
 *
 */
class EmailConfig {

/**
 * test config
 *
 * @var string
 */
	public $test = array(
		'from' => array('some@example.com' => 'My website'),
		'to' => array('test@example.com' => 'Testname'),
		'subject' => 'Test mail subject',
		'transport' => 'Debug',
		'theme' => 'TestTheme',
		'helpers' => array('Html', 'Form'),
	);

}

/*
 * ExtendTransport class
 * test class to ensure the class has send() method
 *
 */
class ExtendTransport {

}

/**
 * CakeEmailTest class
 *
 * @package       Cake.Test.Case.Network.Email
 */
class CakeEmailTest extends TestCase {

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Email = new TestCakeEmail();

		App::build(array(
			'View' => array(CAKE . 'Test' . DS . 'test_app' . DS . 'View' . DS)
		));
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		App::build();
	}

/**
 * testFrom method
 *
 * @return void
 */
	public function testFrom() {
		$this->assertSame($this->Email->from(), array());

		$this->Email->from('cake@cakephp.org');
		$expected = array('cake@cakephp.org' => 'cake@cakephp.org');
		$this->assertSame($this->Email->from(), $expected);

		$this->Email->from(array('cake@cakephp.org'));
		$this->assertSame($this->Email->from(), $expected);

		$this->Email->from('cake@cakephp.org', 'CakePHP');
		$expected = array('cake@cakephp.org' => 'CakePHP');
		$this->assertSame($this->Email->from(), $expected);

		$result = $this->Email->from(array('cake@cakephp.org' => 'CakePHP'));
		$this->assertSame($this->Email->from(), $expected);
		$this->assertSame($this->Email, $result);

		$this->setExpectedException('SocketException');
		$result = $this->Email->from(array('cake@cakephp.org' => 'CakePHP', 'fail@cakephp.org' => 'From can only be one address'));
	}

/**
 * testSender method
 *
 * @return void
 */
	public function testSender() {
		$this->Email->reset();
		$this->assertSame($this->Email->sender(), array());

		$this->Email->sender('cake@cakephp.org', 'Name');
		$expected = array('cake@cakephp.org' => 'Name');
		$this->assertSame($this->Email->sender(), $expected);

		$headers = $this->Email->getHeaders(array('from' => true, 'sender' => true));
		$this->assertSame($headers['From'], false);
		$this->assertSame($headers['Sender'], 'Name <cake@cakephp.org>');

		$this->Email->from('cake@cakephp.org', 'CakePHP');
		$headers = $this->Email->getHeaders(array('from' => true, 'sender' => true));
		$this->assertSame($headers['From'], 'CakePHP <cake@cakephp.org>');
		$this->assertSame($headers['Sender'], '');
	}

/**
 * testTo method
 *
 * @return void
 */
	public function testTo() {
		$this->assertSame($this->Email->to(), array());

		$result = $this->Email->to('cake@cakephp.org');
		$expected = array('cake@cakephp.org' => 'cake@cakephp.org');
		$this->assertSame($this->Email->to(), $expected);
		$this->assertSame($this->Email, $result);

		$this->Email->to('cake@cakephp.org', 'CakePHP');
		$expected = array('cake@cakephp.org' => 'CakePHP');
		$this->assertSame($this->Email->to(), $expected);

		$list = array(
			'cake@cakephp.org' => 'Cake PHP',
			'cake-php@googlegroups.com' => 'Cake Groups',
			'root@cakephp.org'
		);
		$this->Email->to($list);
		$expected = array(
			'cake@cakephp.org' => 'Cake PHP',
			'cake-php@googlegroups.com' => 'Cake Groups',
			'root@cakephp.org' => 'root@cakephp.org'
		);
		$this->assertSame($this->Email->to(), $expected);

		$this->Email->addTo('jrbasso@cakephp.org');
		$this->Email->addTo('mark_story@cakephp.org', 'Mark Story');
		$result = $this->Email->addTo(array('phpnut@cakephp.org' => 'PhpNut', 'jose_zap@cakephp.org'));
		$expected = array(
			'cake@cakephp.org' => 'Cake PHP',
			'cake-php@googlegroups.com' => 'Cake Groups',
			'root@cakephp.org' => 'root@cakephp.org',
			'jrbasso@cakephp.org' => 'jrbasso@cakephp.org',
			'mark_story@cakephp.org' => 'Mark Story',
			'phpnut@cakephp.org' => 'PhpNut',
			'jose_zap@cakephp.org' => 'jose_zap@cakephp.org'
		);
		$this->assertSame($this->Email->to(), $expected);
		$this->assertSame($this->Email, $result);
	}

/**
 * Data provider function for testBuildInvalidData
 *
 * @return array
 */
	public static function invalidEmails() {
		return array(
			array(1.0),
			array(''),
			array('string'),
			array('<tag>'),
			array('some@one.whereis'),
			array('wrong@key' => 'Name'),
			array(array('ok@cakephp.org', 1.0, '', 'string'))
		);
	}

/**
 * testBuildInvalidData
 *
 * @dataProvider invalidEmails
 * @expectedException SocketException
 * @return void
 */
	public function testInvalidEmail($value) {
		$this->Email->to($value);
	}

/**
 * testBuildInvalidData
 *
 * @dataProvider invalidEmails
 * @expectedException SocketException
 * @return void
 */
	public function testInvalidEmailAdd($value) {
		$this->Email->addTo($value);
	}

/**
 * testFormatAddress method
 *
 * @return void
 */
	public function testFormatAddress() {
		$result = $this->Email->formatAddress(array('cake@cakephp.org' => 'cake@cakephp.org'));
		$expected = array('cake@cakephp.org');
		$this->assertSame($expected, $result);

		$result = $this->Email->formatAddress(array('cake@cakephp.org' => 'cake@cakephp.org', 'php@cakephp.org' => 'php@cakephp.org'));
		$expected = array('cake@cakephp.org', 'php@cakephp.org');
		$this->assertSame($expected, $result);

		$result = $this->Email->formatAddress(array('cake@cakephp.org' => 'CakePHP', 'php@cakephp.org' => 'Cake'));
		$expected = array('CakePHP <cake@cakephp.org>', 'Cake <php@cakephp.org>');
		$this->assertSame($expected, $result);

		$result = $this->Email->formatAddress(array('me@example.com' => 'Last, First'));
		$expected = array('"Last, First" <me@example.com>');
		$this->assertSame($expected, $result);

		$result = $this->Email->formatAddress(array('me@example.com' => 'Last First'));
		$expected = array('Last First <me@example.com>');
		$this->assertSame($expected, $result);

		$result = $this->Email->formatAddress(array('cake@cakephp.org' => 'ÄÖÜTest'));
		$expected = array('=?UTF-8?B?w4TDlsOcVGVzdA==?= <cake@cakephp.org>');
		$this->assertSame($expected, $result);

		$result = $this->Email->formatAddress(array('cake@cakephp.org' => '日本語Test'));
		$expected = array('=?UTF-8?B?5pel5pys6KqeVGVzdA==?= <cake@cakephp.org>');
		$this->assertSame($expected, $result);
	}

/**
 * testFormatAddressJapanese
 *
 * @return void
 */
	public function testFormatAddressJapanese() {
		$this->skipIf(!function_exists('mb_convert_encoding'));

		$this->Email->headerCharset = 'ISO-2022-JP';
		$result = $this->Email->formatAddress(array('cake@cakephp.org' => '日本語Test'));
		$expected = array('=?ISO-2022-JP?B?GyRCRnxLXDhsGyhCVGVzdA==?= <cake@cakephp.org>');
		$this->assertSame($expected, $result);

		$result = $this->Email->formatAddress(array('cake@cakephp.org' => '寿限無寿限無五劫の擦り切れ海砂利水魚の水行末雲来末風来末食う寝る処に住む処やぶら小路の藪柑子パイポパイポパイポのシューリンガンシューリンガンのグーリンダイグーリンダイのポンポコピーのポンポコナーの長久命の長助'));
		$expected = array("=?ISO-2022-JP?B?GyRCPHc4Qkw1PHc4Qkw1OF45ZSROOyQkakBaJGwzJDo9TXg/ZTV7GyhC?=\r\n" .
			" =?ISO-2022-JP?B?GyRCJE4/ZTlUS3YxQE1oS3ZJd01oS3Y/KSQmPzIkaz1oJEs9OyRgGyhC?=\r\n" .
			" =?ISO-2022-JP?B?GyRCPWgkZCRWJGk+Lk8pJE5pLjQ7O1IlUSUkJV0lUSUkJV0lUSUkGyhC?=\r\n" .
			" =?ISO-2022-JP?B?GyRCJV0kTiU3JWUhPCVqJXMlLCVzJTclZSE8JWolcyUsJXMkTiUwGyhC?=\r\n" .
			" =?ISO-2022-JP?B?GyRCITwlaiVzJUAlJCUwITwlaiVzJUAlJCROJV0lcyVdJTMlVCE8GyhC?=\r\n" .
			" =?ISO-2022-JP?B?GyRCJE4lXSVzJV0lMyVKITwkTkQ5NVdMPyRORDk9dRsoQg==?= <cake@cakephp.org>");
		$this->assertSame($expected, $result);
	}

/**
 * testAddresses method
 *
 * @return void
 */
	public function testAddresses() {
		$this->Email->reset();
		$this->Email->from('cake@cakephp.org', 'CakePHP');
		$this->Email->replyTo('replyto@cakephp.org', 'ReplyTo CakePHP');
		$this->Email->readReceipt('readreceipt@cakephp.org', 'ReadReceipt CakePHP');
		$this->Email->returnPath('returnpath@cakephp.org', 'ReturnPath CakePHP');
		$this->Email->to('to@cakephp.org', 'To CakePHP');
		$this->Email->cc('cc@cakephp.org', 'Cc CakePHP');
		$this->Email->bcc('bcc@cakephp.org', 'Bcc CakePHP');
		$this->Email->addTo('to2@cakephp.org', 'To2 CakePHP');
		$this->Email->addCc('cc2@cakephp.org', 'Cc2 CakePHP');
		$this->Email->addBcc('bcc2@cakephp.org', 'Bcc2 CakePHP');

		$this->assertSame($this->Email->from(), array('cake@cakephp.org' => 'CakePHP'));
		$this->assertSame($this->Email->replyTo(), array('replyto@cakephp.org' => 'ReplyTo CakePHP'));
		$this->assertSame($this->Email->readReceipt(), array('readreceipt@cakephp.org' => 'ReadReceipt CakePHP'));
		$this->assertSame($this->Email->returnPath(), array('returnpath@cakephp.org' => 'ReturnPath CakePHP'));
		$this->assertSame($this->Email->to(), array('to@cakephp.org' => 'To CakePHP', 'to2@cakephp.org' => 'To2 CakePHP'));
		$this->assertSame($this->Email->cc(), array('cc@cakephp.org' => 'Cc CakePHP', 'cc2@cakephp.org' => 'Cc2 CakePHP'));
		$this->assertSame($this->Email->bcc(), array('bcc@cakephp.org' => 'Bcc CakePHP', 'bcc2@cakephp.org' => 'Bcc2 CakePHP'));

		$headers = $this->Email->getHeaders(array_fill_keys(array('from', 'replyTo', 'readReceipt', 'returnPath', 'to', 'cc', 'bcc'), true));
		$this->assertSame($headers['From'], 'CakePHP <cake@cakephp.org>');
		$this->assertSame($headers['Reply-To'], 'ReplyTo CakePHP <replyto@cakephp.org>');
		$this->assertSame($headers['Disposition-Notification-To'], 'ReadReceipt CakePHP <readreceipt@cakephp.org>');
		$this->assertSame($headers['Return-Path'], 'ReturnPath CakePHP <returnpath@cakephp.org>');
		$this->assertSame($headers['To'], 'To CakePHP <to@cakephp.org>, To2 CakePHP <to2@cakephp.org>');
		$this->assertSame($headers['Cc'], 'Cc CakePHP <cc@cakephp.org>, Cc2 CakePHP <cc2@cakephp.org>');
		$this->assertSame($headers['Bcc'], 'Bcc CakePHP <bcc@cakephp.org>, Bcc2 CakePHP <bcc2@cakephp.org>');
	}

/**
 * testMessageId method
 *
 * @return void
 */
	public function testMessageId() {
		$this->Email->messageId(true);
		$result = $this->Email->getHeaders();
		$this->assertTrue(isset($result['Message-ID']));

		$this->Email->messageId(false);
		$result = $this->Email->getHeaders();
		$this->assertFalse(isset($result['Message-ID']));

		$result = $this->Email->messageId('<my-email@localhost>');
		$this->assertSame($this->Email, $result);
		$result = $this->Email->getHeaders();
		$this->assertSame($result['Message-ID'], '<my-email@localhost>');

		$result = $this->Email->messageId();
		$this->assertSame($result, '<my-email@localhost>');
	}

/**
 * testMessageIdInvalid method
 *
 * @return void
 * @expectedException SocketException
 */
	public function testMessageIdInvalid() {
		$this->Email->messageId('my-email@localhost');
	}

/**
 * testDomain method
 *
 * @return void
 */
	public function testDomain() {
		$result = $this->Email->domain();
		$expected = env('HTTP_HOST') ? env('HTTP_HOST') : php_uname('n');
		$this->assertSame($expected, $result);

		$this->Email->domain('example.org');
		$result = $this->Email->domain();
		$expected = 'example.org';
		$this->assertSame($expected, $result);
	}

/**
 * testMessageIdWithDomain method
 *
 * @return void
 */
	public function testMessageIdWithDomain() {
		$this->Email->domain('example.org');
		$result = $this->Email->getHeaders();
		$expected = '@example.org>';
		$this->assertTextContains($expected, $result['Message-ID']);

		$_SERVER['HTTP_HOST'] = 'example.org';
		$result = $this->Email->getHeaders();
		$this->assertTextContains('example.org', $result['Message-ID']);

		$_SERVER['HTTP_HOST'] = 'example.org:81';
		$result = $this->Email->getHeaders();
		$this->assertTextNotContains(':81', $result['Message-ID']);
	}

/**
 * testSubject method
 *
 * @return void
 */
	public function testSubject() {
		$this->Email->subject('You have a new message.');
		$this->assertSame($this->Email->subject(), 'You have a new message.');

		$this->Email->subject('You have a new message, I think.');
		$this->assertSame($this->Email->subject(), 'You have a new message, I think.');
		$this->Email->subject(1);
		$this->assertSame($this->Email->subject(), '1');

		$this->Email->subject('هذه رسالة بعنوان طويل مرسل للمستلم');
		$expected = '=?UTF-8?B?2YfYsNmHINix2LPYp9mE2Kkg2KjYudmG2YjYp9mGINi32YjZitmEINmF2LE=?=' . "\r\n" . ' =?UTF-8?B?2LPZhCDZhNmE2YXYs9iq2YTZhQ==?=';
		$this->assertSame($this->Email->subject(), $expected);
	}

/**
 * testSubjectJapanese
 *
 * @return void
 */
	public function testSubjectJapanese() {
		$this->skipIf(!function_exists('mb_convert_encoding'));
		mb_internal_encoding('UTF-8');

		$this->Email->headerCharset = 'ISO-2022-JP';
		$this->Email->subject('日本語のSubjectにも対応するよ');
		$expected = '=?ISO-2022-JP?B?GyRCRnxLXDhsJE4bKEJTdWJqZWN0GyRCJEskYkJQMX4kOSRrJGgbKEI=?=';
		$this->assertSame($this->Email->subject(), $expected);

		$this->Email->subject('長い長い長いSubjectの場合はfoldingするのが正しいんだけどいったいどうなるんだろう？');
		$expected = "=?ISO-2022-JP?B?GyRCRDkkJEQ5JCREOSQkGyhCU3ViamVjdBskQiROPmw5ZyRPGyhCZm9s?=\r\n" .
			" =?ISO-2022-JP?B?ZGluZxskQiQ5JGskTiQsQDUkNyQkJHMkQCQxJEkkJCRDJD8kJCRJGyhC?=\r\n" .
			" =?ISO-2022-JP?B?GyRCJCYkSiRrJHMkQCRtJCYhKRsoQg==?=";
		$this->assertSame($this->Email->subject(), $expected);
	}

/**
 * testHeaders method
 *
 * @return void
 */
	public function testHeaders() {
		$this->Email->messageId(false);
		$this->Email->setHeaders(array('X-Something' => 'nice'));
		$expected = array(
			'X-Something' => 'nice',
			'X-Mailer' => 'CakePHP Email',
			'Date' => date(DATE_RFC2822),
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/plain; charset=UTF-8',
			'Content-Transfer-Encoding' => '8bit'
		);
		$this->assertSame($this->Email->getHeaders(), $expected);

		$this->Email->addHeaders(array('X-Something' => 'very nice', 'X-Other' => 'cool'));
		$expected = array(
			'X-Something' => 'very nice',
			'X-Other' => 'cool',
			'X-Mailer' => 'CakePHP Email',
			'Date' => date(DATE_RFC2822),
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/plain; charset=UTF-8',
			'Content-Transfer-Encoding' => '8bit'
		);
		$this->assertSame($this->Email->getHeaders(), $expected);

		$this->Email->from('cake@cakephp.org');
		$this->assertSame($this->Email->getHeaders(), $expected);

		$expected = array(
			'From' => 'cake@cakephp.org',
			'X-Something' => 'very nice',
			'X-Other' => 'cool',
			'X-Mailer' => 'CakePHP Email',
			'Date' => date(DATE_RFC2822),
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/plain; charset=UTF-8',
			'Content-Transfer-Encoding' => '8bit'
		);
		$this->assertSame($this->Email->getHeaders(array('from' => true)), $expected);

		$this->Email->from('cake@cakephp.org', 'CakePHP');
		$expected['From'] = 'CakePHP <cake@cakephp.org>';
		$this->assertSame($this->Email->getHeaders(array('from' => true)), $expected);

		$this->Email->to(array('cake@cakephp.org', 'php@cakephp.org' => 'CakePHP'));
		$expected = array(
			'From' => 'CakePHP <cake@cakephp.org>',
			'To' => 'cake@cakephp.org, CakePHP <php@cakephp.org>',
			'X-Something' => 'very nice',
			'X-Other' => 'cool',
			'X-Mailer' => 'CakePHP Email',
			'Date' => date(DATE_RFC2822),
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/plain; charset=UTF-8',
			'Content-Transfer-Encoding' => '8bit'
		);
		$this->assertSame($this->Email->getHeaders(array('from' => true, 'to' => true)), $expected);

		$this->Email->charset = 'ISO-2022-JP';
		$expected = array(
			'From' => 'CakePHP <cake@cakephp.org>',
			'To' => 'cake@cakephp.org, CakePHP <php@cakephp.org>',
			'X-Something' => 'very nice',
			'X-Other' => 'cool',
			'X-Mailer' => 'CakePHP Email',
			'Date' => date(DATE_RFC2822),
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/plain; charset=ISO-2022-JP',
			'Content-Transfer-Encoding' => '7bit'
		);
		$this->assertSame($this->Email->getHeaders(array('from' => true, 'to' => true)), $expected);

		$result = $this->Email->setHeaders(array());
		$this->assertInstanceOf('Email', $result);
	}

/**
 * Data provider function for testInvalidHeaders
 *
 * @return array
 */
	public static function invalidHeaders() {
		return array(
			array(10),
			array(''),
			array('string'),
			array(false),
			array(null)
		);
	}

/**
 * testInvalidHeaders
 *
 * @dataProvider invalidHeaders
 * @expectedException SocketException
 * @return void
 */
	public function testInvalidHeaders($value) {
		$this->Email->setHeaders($value);
	}

/**
 * testInvalidAddHeaders
 *
 * @dataProvider invalidHeaders
 * @expectedException SocketException
 * @return void
 */
	public function testInvalidAddHeaders($value) {
		$this->Email->addHeaders($value);
	}

/**
 * testTemplate method
 *
 * @return void
 */
	public function testTemplate() {
		$this->Email->template('template', 'layout');
		$expected = array('template' => 'template', 'layout' => 'layout');
		$this->assertSame($this->Email->template(), $expected);

		$this->Email->template('new_template');
		$expected = array('template' => 'new_template', 'layout' => 'layout');
		$this->assertSame($this->Email->template(), $expected);

		$this->Email->template('template', null);
		$expected = array('template' => 'template', 'layout' => null);
		$this->assertSame($this->Email->template(), $expected);

		$this->Email->template(null, null);
		$expected = array('template' => null, 'layout' => null);
		$this->assertSame($this->Email->template(), $expected);
	}

/**
 * testTheme method
 *
 * @return void
 */
	public function testTheme() {
		$this->assertSame(null, $this->Email->theme());

		$this->Email->theme('default');
		$expected = 'default';
		$this->assertSame($expected, $this->Email->theme());
	}

/**
 * testViewVars method
 *
 * @return void
 */
	public function testViewVars() {
		$this->assertSame($this->Email->viewVars(), array());

		$this->Email->viewVars(array('value' => 12345));
		$this->assertSame($this->Email->viewVars(), array('value' => 12345));

		$this->Email->viewVars(array('name' => 'CakePHP'));
		$this->assertSame($this->Email->viewVars(), array('value' => 12345, 'name' => 'CakePHP'));

		$this->Email->viewVars(array('value' => 4567));
		$this->assertSame($this->Email->viewVars(), array('value' => 4567, 'name' => 'CakePHP'));
	}

/**
 * testAttachments method
 *
 * @return void
 */
	public function testAttachments() {
		$this->Email->attachments(CAKE . 'basics.php');
		$expected = array('basics.php' => array('file' => CAKE . 'basics.php', 'mimetype' => 'application/octet-stream'));
		$this->assertSame($this->Email->attachments(), $expected);

		$this->Email->attachments(array());
		$this->assertSame($this->Email->attachments(), array());

		$this->Email->attachments(array(array('file' => CAKE . 'basics.php', 'mimetype' => 'text/plain')));
		$this->Email->addAttachments(CAKE . 'bootstrap.php');
		$this->Email->addAttachments(array(CAKE . 'bootstrap.php'));
		$this->Email->addAttachments(array('other.txt' => CAKE . 'bootstrap.php', 'license' => CAKE . 'LICENSE.txt'));
		$expected = array(
			'basics.php' => array('file' => CAKE . 'basics.php', 'mimetype' => 'text/plain'),
			'bootstrap.php' => array('file' => CAKE . 'bootstrap.php', 'mimetype' => 'application/octet-stream'),
			'other.txt' => array('file' => CAKE . 'bootstrap.php', 'mimetype' => 'application/octet-stream'),
			'license' => array('file' => CAKE . 'LICENSE.txt', 'mimetype' => 'application/octet-stream')
		);
		$this->assertSame($this->Email->attachments(), $expected);

		$this->setExpectedException('SocketException');
		$this->Email->attachments(array(array('nofile' => CAKE . 'basics.php', 'mimetype' => 'text/plain')));
	}

/**
 * testTransport method
 *
 * @return void
 */
	public function testTransport() {
		$result = $this->Email->transport('Debug');
		$this->assertSame($this->Email, $result);
		$this->assertSame($this->Email->transport(), 'Debug');

		$result = $this->Email->transportClass();
		$this->assertInstanceOf('DebugTransport', $result);

		$this->setExpectedException('SocketException');
		$this->Email->transport('Invalid');
		$result = $this->Email->transportClass();
	}

/**
 * testExtendTransport method
 *
 * @return void
 */
	public function testExtendTransport() {
		$this->setExpectedException('SocketException');
		$this->Email->transport('Extend');
		$result = $this->Email->transportClass();
	}

/**
 * testConfig method
 *
 * @return void
 */
	public function testConfig() {
		$transportClass = $this->Email->transport('debug')->transportClass();

		$config = array('test' => 'ok', 'test2' => true);
		$this->Email->config($config);
		$this->assertSame($transportClass->config(), $config);
		$this->assertSame($this->Email->config(), $config);

		$this->Email->config(array());
		$this->assertSame($transportClass->config(), array());
	}

/**
 * testConfigString method
 *
 * @return void
 */
	public function testConfigString() {
		$configs = new EmailConfig();
		$this->Email->config('test');

		$result = $this->Email->to();
		$this->assertEquals($configs->test['to'], $result);

		$result = $this->Email->from();
		$this->assertEquals($configs->test['from'], $result);

		$result = $this->Email->subject();
		$this->assertEquals($configs->test['subject'], $result);

		$result = $this->Email->theme();
		$this->assertEquals($configs->test['theme'], $result);

		$result = $this->Email->transport();
		$this->assertEquals($configs->test['transport'], $result);

		$result = $this->Email->transportClass();
		$this->assertInstanceOf('DebugTransport', $result);

		$result = $this->Email->helpers();
		$this->assertEquals($configs->test['helpers'], $result);
	}

/**
 * testSendWithContent method
 *
 * @return void
 */
	public function testSendWithContent() {
		$this->Email->reset();
		$this->Email->transport('Debug');
		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));

		$result = $this->Email->send("Here is my body, with multi lines.\nThis is the second line.\r\n\r\nAnd the last.");
		$expected = array('headers', 'message');
		$this->assertEquals($expected, array_keys($result));
		$expected = "Here is my body, with multi lines.\r\nThis is the second line.\r\n\r\nAnd the last.\r\n\r\n";

		$this->assertEquals($expected, $result['message']);
		$this->assertTrue((bool)strpos($result['headers'], 'Date: '));
		$this->assertTrue((bool)strpos($result['headers'], 'Message-ID: '));
		$this->assertTrue((bool)strpos($result['headers'], 'To: '));

		$result = $this->Email->send("Other body");
		$expected = "Other body\r\n\r\n";
		$this->assertSame($result['message'], $expected);
		$this->assertTrue((bool)strpos($result['headers'], 'Message-ID: '));
		$this->assertTrue((bool)strpos($result['headers'], 'To: '));

		$this->Email->reset();
		$this->Email->transport('Debug');
		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));
		$result = $this->Email->send(array('Sending content', 'As array'));
		$expected = "Sending content\r\nAs array\r\n\r\n\r\n";
		$this->assertSame($result['message'], $expected);
	}

/**
 * testSendWithoutFrom method
 *
 * @return void
 */
	public function testSendWithoutFrom() {
		$this->Email->transport('Debug');
		$this->Email->to('cake@cakephp.org');
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));
		$this->setExpectedException('SocketException');
		$this->Email->send("Forgot to set From");
	}

/**
 * testSendWithoutTo method
 *
 * @return void
 */
	public function testSendWithoutTo() {
		$this->Email->transport('Debug');
		$this->Email->from('cake@cakephp.org');
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));
		$this->setExpectedException('SocketException');
		$this->Email->send("Forgot to set To");
	}

/**
 * Test send() with no template.
 *
 * @return void
 */
	public function testSendNoTemplateWithAttachments() {
		$this->Email->transport('debug');
		$this->Email->from('cake@cakephp.org');
		$this->Email->to('cake@cakephp.org');
		$this->Email->subject('My title');
		$this->Email->emailFormat('text');
		$this->Email->attachments(array(CAKE . 'basics.php'));
		$result = $this->Email->send('Hello');

		$boundary = $this->Email->getBoundary();
		$this->assertContains('Content-Type: multipart/mixed; boundary="' . $boundary . '"', $result['headers']);
		$expected = "--$boundary\r\n" .
			"Content-Type: text/plain; charset=UTF-8\r\n" .
			"Content-Transfer-Encoding: 8bit\r\n" .
			"\r\n" .
			"Hello" .
			"\r\n" .
			"\r\n" .
			"\r\n" .
			"--$boundary\r\n" .
			"Content-Type: application/octet-stream\r\n" .
			"Content-Transfer-Encoding: base64\r\n" .
			"Content-Disposition: attachment; filename=\"basics.php\"\r\n\r\n";
		$this->assertContains($expected, $result['message']);
	}

/**
 * Test send() with no template as both
 *
 * @return void
 */
	public function testSendNoTemplateWithAttachmentsAsBoth() {
		$this->Email->transport('debug');
		$this->Email->from('cake@cakephp.org');
		$this->Email->to('cake@cakephp.org');
		$this->Email->subject('My title');
		$this->Email->emailFormat('both');
		$this->Email->attachments(array(CAKE . 'VERSION.txt'));
		$result = $this->Email->send('Hello');

		$boundary = $this->Email->getBoundary();
		$this->assertContains('Content-Type: multipart/mixed; boundary="' . $boundary . '"', $result['headers']);
		$expected = "--$boundary\r\n" .
			"Content-Type: multipart/alternative; boundary=\"alt-$boundary\"\r\n" .
			"\r\n" .
			"--alt-$boundary\r\n" .
			"Content-Type: text/plain; charset=UTF-8\r\n" .
			"Content-Transfer-Encoding: 8bit\r\n" .
			"\r\n" .
			"Hello" .
			"\r\n" .
			"\r\n" .
			"\r\n" .
			"--alt-$boundary\r\n" .
			"Content-Type: text/html; charset=UTF-8\r\n" .
			"Content-Transfer-Encoding: 8bit\r\n" .
			"\r\n" .
			"Hello" .
			"\r\n" .
			"\r\n" .
			"\r\n" .
			"--alt-{$boundary}--\r\n" .
			"\r\n" .
			"--$boundary\r\n" .
			"Content-Type: application/octet-stream\r\n" .
			"Content-Transfer-Encoding: base64\r\n" .
			"Content-Disposition: attachment; filename=\"VERSION.txt\"\r\n\r\n";
		$this->assertContains($expected, $result['message']);
	}

/**
 * Test setting inline attachments and messages.
 *
 * @return void
 */
	public function testSendWithInlineAttachments() {
		$this->Email->transport('debug');
		$this->Email->from('cake@cakephp.org');
		$this->Email->to('cake@cakephp.org');
		$this->Email->subject('My title');
		$this->Email->emailFormat('both');
		$this->Email->attachments(array(
			'cake.png' => array(
				'file' => CAKE . 'VERSION.txt',
				'contentId' => 'abc123'
			)
		));
		$result = $this->Email->send('Hello');

		$boundary = $this->Email->getBoundary();
		$this->assertContains('Content-Type: multipart/mixed; boundary="' . $boundary . '"', $result['headers']);
		$expected = "--$boundary\r\n" .
			"Content-Type: multipart/related; boundary=\"rel-$boundary\"\r\n" .
			"\r\n" .
			"--rel-$boundary\r\n" .
			"Content-Type: multipart/alternative; boundary=\"alt-$boundary\"\r\n" .
			"\r\n" .
			"--alt-$boundary\r\n" .
			"Content-Type: text/plain; charset=UTF-8\r\n" .
			"Content-Transfer-Encoding: 8bit\r\n" .
			"\r\n" .
			"Hello" .
			"\r\n" .
			"\r\n" .
			"\r\n" .
			"--alt-$boundary\r\n" .
			"Content-Type: text/html; charset=UTF-8\r\n" .
			"Content-Transfer-Encoding: 8bit\r\n" .
			"\r\n" .
			"Hello" .
			"\r\n" .
			"\r\n" .
			"\r\n" .
			"--alt-{$boundary}--\r\n" .
			"\r\n" .
			"--rel-$boundary\r\n" .
			"Content-Type: application/octet-stream\r\n" .
			"Content-Transfer-Encoding: base64\r\n" .
			"Content-ID: <abc123>\r\n" .
			"Content-Disposition: inline; filename=\"cake.png\"\r\n\r\n";
		$this->assertContains($expected, $result['message']);
		$this->assertContains('--rel-' . $boundary . '--', $result['message']);
		$this->assertContains('--' . $boundary . '--', $result['message']);
	}

/**
 * testSendWithLog method
 *
 * @return void
 */
	public function testSendWithLog() {
		$path = CAKE . 'Test' . DS . 'test_app' . DS . 'tmp' . DS;
		Log::config('email', array(
			'engine' => 'FileLog',
			'path' => TMP
		));
		Log::drop('default');
		$this->Email->transport('Debug');
		$this->Email->to('me@cakephp.org');
		$this->Email->from('cake@cakephp.org');
		$this->Email->subject('My title');
		$this->Email->config(array('log' => 'cake_test_emails'));
		$result = $this->Email->send("Logging This");

		$File = new File(TMP . 'cake_test_emails.log');
		$log = $File->read();
		$this->assertTrue(strpos($log, $result['headers']) !== false);
		$this->assertTrue(strpos($log, $result['message']) !== false);
		$File->delete();
		Log::drop('email');
	}

/**
 * testSendRender method
 *
 * @return void
 */
	public function testSendRender() {
		$this->Email->reset();
		$this->Email->transport('debug');

		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));
		$this->Email->template('default', 'default');
		$result = $this->Email->send();

		$this->assertContains('This email was sent using the CakePHP Framework', $result['message']);
		$this->assertContains('Message-ID: ', $result['headers']);
		$this->assertContains('To: ', $result['headers']);
	}

/**
 * testSendRender method for ISO-2022-JP
 *
 * @return void
 */
	public function testSendRenderJapanese() {
		$this->skipIf(!function_exists('mb_convert_encoding'));

		$this->Email->reset();
		$this->Email->transport('debug');

		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));
		$this->Email->template('default', 'japanese');
		$this->Email->charset = 'ISO-2022-JP';
		$result = $this->Email->send();

		$expected = mb_convert_encoding('CakePHP Framework を使って送信したメールです。 http://cakephp.org.', 'ISO-2022-JP');
		$this->assertContains($expected, $result['message']);
		$this->assertContains('Message-ID: ', $result['headers']);
		$this->assertContains('To: ', $result['headers']);
	}

/**
 * testSendRenderThemed method
 *
 * @return void
 */
	public function testSendRenderThemed() {
		$this->Email->reset();
		$this->Email->transport('debug');

		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));
		$this->Email->theme('TestTheme');
		$this->Email->template('themed', 'default');
		$result = $this->Email->send();

		$this->assertContains('In TestTheme', $result['message']);
		$this->assertContains('Message-ID: ', $result['headers']);
		$this->assertContains('To: ', $result['headers']);
	}

/**
 * testSendRenderWithVars method
 *
 * @return void
 */
	public function testSendRenderWithVars() {
		$this->Email->reset();
		$this->Email->transport('debug');

		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));
		$this->Email->template('custom', 'default');
		$this->Email->viewVars(array('value' => 12345));
		$result = $this->Email->send();

		$this->assertContains('Here is your value: 12345', $result['message']);
	}

/**
 * testSendRenderWithVars method for ISO-2022-JP
 *
 * @return void
 */
	public function testSendRenderWithVarsJapanese() {
		$this->skipIf(!function_exists('mb_convert_encoding'));
		$this->Email->reset();
		$this->Email->transport('debug');

		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));
		$this->Email->template('japanese', 'default');
		$this->Email->viewVars(array('value' => '日本語の差し込み123'));
		$this->Email->charset = 'ISO-2022-JP';
		$result = $this->Email->send();

		$expected = mb_convert_encoding('ここにあなたの設定した値が入ります: 日本語の差し込み123', 'ISO-2022-JP');
		$this->assertTrue((bool)strpos($result['message'], $expected));
	}

/**
 * testSendRenderWithHelpers method
 *
 * @return void
 */
	public function testSendRenderWithHelpers() {
		$this->Email->reset();
		$this->Email->transport('debug');

		$timestamp = time();
		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));
		$this->Email->template('custom_helper', 'default');
		$this->Email->viewVars(array('time' => $timestamp));

		$result = $this->Email->helpers(array('Time'));
		$this->assertInstanceOf('Email', $result);

		$result = $this->Email->send();
		$this->assertTrue((bool)strpos($result['message'], 'Right now: ' . date('Y-m-d\TH:i:s\Z', $timestamp)));

		$result = $this->Email->helpers();
		$this->assertEquals(array('Time'), $result);
	}

/**
 * testSendRenderWithImage method
 *
 * @return void
 */
	public function testSendRenderWithImage() {
		$this->Email->reset();
		$this->Email->transport('Debug');

		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));
		$this->Email->template('image');
		$this->Email->emailFormat('html');
		$server = env('SERVER_NAME') ? env('SERVER_NAME') : 'localhost';

		if (env('SERVER_PORT') != null && env('SERVER_PORT') != 80) {
			$server .= ':' . env('SERVER_PORT');
		}

		$expected = '<img src="http://' . $server . '/img/image.gif" alt="cool image" width="100" height="100" />';
		$result = $this->Email->send();
		$this->assertContains($expected, $result['message']);
	}

/**
 * testSendRenderPlugin method
 *
 * @return void
 */
	public function testSendRenderPlugin() {
		App::build(array(
			'Plugin' => array(CAKE . 'Test' . DS . 'test_app' . DS . 'Plugin' . DS)
		));
		Plugin::load('TestPlugin');

		$this->Email->reset();
		$this->Email->transport('debug');
		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));

		$result = $this->Email->template('TestPlugin.test_plugin_tpl', 'default')->send();
		$this->assertContains('Into TestPlugin.', $result['message']);
		$this->assertContains('This email was sent using the CakePHP Framework', $result['message']);

		$result = $this->Email->template('TestPlugin.test_plugin_tpl', 'TestPlugin.plug_default')->send();
		$this->assertContains('Into TestPlugin.', $result['message']);
		$this->assertContains('This email was sent using the TestPlugin.', $result['message']);

		$result = $this->Email->template('TestPlugin.test_plugin_tpl', 'plug_default')->send();
		$this->assertContains('Into TestPlugin.', $result['message']);
		$this->assertContains('This email was sent using the TestPlugin.', $result['message']);

		// test plugin template overridden by theme
		$this->Email->theme('TestTheme');
		$result = $this->Email->send();

		$this->assertContains('Into TestPlugin. (themed)', $result['message']);

		$this->Email->viewVars(array('value' => 12345));
		$result = $this->Email->template('custom', 'TestPlugin.plug_default')->send();
		$this->assertContains('Here is your value: 12345', $result['message']);
		$this->assertContains('This email was sent using the TestPlugin.', $result['message']);

		$this->setExpectedException('MissingViewException');
		$this->Email->template('test_plugin_tpl', 'plug_default')->send();
	}

/**
 * testSendMultipleMIME method
 *
 * @return void
 */
	public function testSendMultipleMIME() {
		$this->Email->reset();
		$this->Email->transport('debug');

		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->template('custom', 'default');
		$this->Email->config(array());
		$this->Email->viewVars(array('value' => 12345));
		$this->Email->emailFormat('both');
		$result = $this->Email->send();

		$message = $this->Email->message();
		$boundary = $this->Email->getBoundary();
		$this->assertFalse(empty($boundary));
		$this->assertContains('--' . $boundary, $message);
		$this->assertContains('--' . $boundary . '--', $message);
		$this->assertContains('--alt-' . $boundary, $message);
		$this->assertContains('--alt-' . $boundary . '--', $message);

		$this->Email->attachments(array('fake.php' => __FILE__));
		$this->Email->send();

		$message = $this->Email->message();
		$boundary = $this->Email->getBoundary();
		$this->assertFalse(empty($boundary));
		$this->assertContains('--' . $boundary, $message);
		$this->assertContains('--' . $boundary . '--', $message);
		$this->assertContains('--alt-' . $boundary, $message);
		$this->assertContains('--alt-' . $boundary . '--', $message);
	}

/**
 * testSendAttachment method
 *
 * @return void
 */
	public function testSendAttachment() {
		$this->Email->reset();
		$this->Email->transport('debug');
		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array());
		$this->Email->attachments(array(CAKE . 'basics.php'));
		$result = $this->Email->send('body');
		$this->assertContains("Content-Type: application/octet-stream\r\nContent-Transfer-Encoding: base64\r\nContent-Disposition: attachment; filename=\"basics.php\"", $result['message']);

		$this->Email->attachments(array('my.file.txt' => CAKE . 'basics.php'));
		$result = $this->Email->send('body');
		$this->assertContains("Content-Type: application/octet-stream\r\nContent-Transfer-Encoding: base64\r\nContent-Disposition: attachment; filename=\"my.file.txt\"", $result['message']);

		$this->Email->attachments(array('file.txt' => array('file' => CAKE . 'basics.php', 'mimetype' => 'text/plain')));
		$result = $this->Email->send('body');
		$this->assertContains("Content-Type: text/plain\r\nContent-Transfer-Encoding: base64\r\nContent-Disposition: attachment; filename=\"file.txt\"", $result['message']);

		$this->Email->attachments(array('file2.txt' => array('file' => CAKE . 'basics.php', 'mimetype' => 'text/plain', 'contentId' => 'a1b1c1')));
		$result = $this->Email->send('body');
		$this->assertContains("Content-Type: text/plain\r\nContent-Transfer-Encoding: base64\r\nContent-ID: <a1b1c1>\r\nContent-Disposition: inline; filename=\"file2.txt\"", $result['message']);
	}

/**
 * testDeliver method
 *
 * @return void
 */
	public function testDeliver() {
		$instance = Email::deliver('all@cakephp.org', 'About', 'Everything ok', array('from' => 'root@cakephp.org'), false);
		$this->assertInstanceOf('Email', $instance);
		$this->assertSame($instance->to(), array('all@cakephp.org' => 'all@cakephp.org'));
		$this->assertSame($instance->subject(), 'About');
		$this->assertSame($instance->from(), array('root@cakephp.org' => 'root@cakephp.org'));

		$config = array(
			'from' => 'cake@cakephp.org',
			'to' => 'debug@cakephp.org',
			'subject' => 'Update ok',
			'template' => 'custom',
			'layout' => 'custom_layout',
			'viewVars' => array('value' => 123),
			'cc' => array('cake@cakephp.org' => 'Myself')
		);
		$instance = Email::deliver(null, null, array('name' => 'CakePHP'), $config, false);
		$this->assertSame($instance->from(), array('cake@cakephp.org' => 'cake@cakephp.org'));
		$this->assertSame($instance->to(), array('debug@cakephp.org' => 'debug@cakephp.org'));
		$this->assertSame($instance->subject(), 'Update ok');
		$this->assertSame($instance->template(), array('template' => 'custom', 'layout' => 'custom_layout'));
		$this->assertSame($instance->viewVars(), array('value' => 123, 'name' => 'CakePHP'));
		$this->assertSame($instance->cc(), array('cake@cakephp.org' => 'Myself'));

		$configs = array('from' => 'root@cakephp.org', 'message' => 'Message from configs', 'transport' => 'Debug');
		$instance = Email::deliver('all@cakephp.org', 'About', null, $configs, true);
		$message = $instance->message();
		$this->assertEquals($configs['message'], $message[0]);
	}

/**
 * testMessage method
 *
 * @return void
 */
	public function testMessage() {
		$this->Email->reset();
		$this->Email->transport('debug');
		$this->Email->from('cake@cakephp.org');
		$this->Email->to(array('you@cakephp.org' => 'You'));
		$this->Email->subject('My title');
		$this->Email->config(array('empty'));
		$this->Email->template('default', 'default');
		$this->Email->emailFormat('both');
		$result = $this->Email->send();

		$expected = '<p>This email was sent using the <a href="http://cakephp.org">CakePHP Framework</a></p>';
		$this->assertContains($expected, $this->Email->message(Email::MESSAGE_HTML));

		$expected = 'This email was sent using the CakePHP Framework, http://cakephp.org.';
		$this->assertContains($expected, $this->Email->message(Email::MESSAGE_TEXT));

		$message = $this->Email->message();
		$this->assertContains('Content-Type: text/plain; charset=UTF-8', $message);
		$this->assertContains('Content-Type: text/html; charset=UTF-8', $message);

		// UTF-8 is 8bit
		$this->assertTrue($this->_checkContentTransferEncoding($message, '8bit'));

		$this->Email->charset = 'ISO-2022-JP';
		$this->Email->send();
		$message = $this->Email->message();
		$this->assertContains('Content-Type: text/plain; charset=ISO-2022-JP', $message);
		$this->assertContains('Content-Type: text/html; charset=ISO-2022-JP', $message);

		// ISO-2022-JP is 7bit
		$this->assertTrue($this->_checkContentTransferEncoding($message, '7bit'));
	}

/**
 * testReset method
 *
 * @return void
 */
	public function testReset() {
		$this->Email->to('cake@cakephp.org');
		$this->Email->theme('TestTheme');
		$this->assertSame($this->Email->to(), array('cake@cakephp.org' => 'cake@cakephp.org'));

		$this->Email->reset();
		$this->assertSame($this->Email->to(), array());
		$this->assertSame(null, $this->Email->theme());
	}

/**
 * testReset with charset
 *
 * @return void
 */
	public function testResetWithCharset() {
		$this->Email->charset = 'ISO-2022-JP';
		$this->Email->reset();

		$this->assertSame($this->Email->charset, 'utf-8', $this->Email->charset);
		$this->assertSame($this->Email->headerCharset, null, $this->Email->headerCharset);
	}

/**
 * testWrap method
 *
 * @return void
 */
	public function testWrap() {
		$text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ac turpis orci, non commodo odio. Morbi nibh nisi, vehicula pellentesque accumsan amet.';
		$result = $this->Email->wrap($text);
		$expected = array(
			'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ac turpis orci,',
			'non commodo odio. Morbi nibh nisi, vehicula pellentesque accumsan amet.',
			''
		);
		$this->assertSame($expected, $result);

		$text = 'Lorem ipsum dolor sit amet, consectetur < adipiscing elit. Donec ac turpis orci, non commodo odio. Morbi nibh nisi, vehicula > pellentesque accumsan amet.';
		$result = $this->Email->wrap($text);
		$expected = array(
			'Lorem ipsum dolor sit amet, consectetur < adipiscing elit. Donec ac turpis',
			'orci, non commodo odio. Morbi nibh nisi, vehicula > pellentesque accumsan',
			'amet.',
			''
		);
		$this->assertSame($expected, $result);

		$text = '<p>Lorem ipsum dolor sit amet,<br> consectetur adipiscing elit.<br> Donec ac turpis orci, non <b>commodo</b> odio. <br /> Morbi nibh nisi, vehicula pellentesque accumsan amet.<hr></p>';
		$result = $this->Email->wrap($text);
		$expected = array(
			'<p>Lorem ipsum dolor sit amet,<br> consectetur adipiscing elit.<br> Donec ac',
			'turpis orci, non <b>commodo</b> odio. <br /> Morbi nibh nisi, vehicula',
			'pellentesque accumsan amet.<hr></p>',
			''
		);
		$this->assertSame($expected, $result);

		$text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ac <a href="http://cakephp.org">turpis</a> orci, non commodo odio. Morbi nibh nisi, vehicula pellentesque accumsan amet.';
		$result = $this->Email->wrap($text);
		$expected = array(
			'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ac',
			'<a href="http://cakephp.org">turpis</a> orci, non commodo odio. Morbi nibh',
			'nisi, vehicula pellentesque accumsan amet.',
			''
		);
		$this->assertSame($expected, $result);

		$text = 'Lorem ipsum <a href="http://www.cakephp.org/controller/action/param1/param2" class="nice cool fine amazing awesome">ok</a>';
		$result = $this->Email->wrap($text);
		$expected = array(
			'Lorem ipsum',
			'<a href="http://www.cakephp.org/controller/action/param1/param2" class="nice cool fine amazing awesome">',
			'ok</a>',
			''
		);
		$this->assertSame($expected, $result);

		$text = 'Lorem ipsum withonewordverybigMorethanthelineshouldsizeofrfcspecificationbyieeeavailableonieeesite ok.';
		$result = $this->Email->wrap($text);
		$expected = array(
			'Lorem ipsum',
			'withonewordverybigMorethanthelineshouldsizeofrfcspecificationbyieeeavailableonieeesite',
			'ok.',
			''
		);
		$this->assertSame($expected, $result);
	}

/**
 * testConstructWithConfigArray method
 *
 * @return void
 */
	public function testConstructWithConfigArray() {
		$configs = array(
			'from' => array('some@example.com' => 'My website'),
			'to' => 'test@example.com',
			'subject' => 'Test mail subject',
			'transport' => 'Debug',
		);
		$this->Email = new Email($configs);

		$result = $this->Email->to();
		$this->assertEquals(array($configs['to'] => $configs['to']), $result);

		$result = $this->Email->from();
		$this->assertEquals($configs['from'], $result);

		$result = $this->Email->subject();
		$this->assertEquals($configs['subject'], $result);

		$result = $this->Email->transport();
		$this->assertEquals($configs['transport'], $result);

		$result = $this->Email->transportClass();
		$this->assertTrue($result instanceof DebugTransport);

		$result = $this->Email->send('This is the message');

		$this->assertTrue((bool)strpos($result['headers'], 'Message-ID: '));
		$this->assertTrue((bool)strpos($result['headers'], 'To: '));
	}

/**
 * testConstructWithConfigString method
 *
 * @return void
 */
	public function testConstructWithConfigString() {
		$configs = new EmailConfig();
		$this->Email = new Email('test');

		$result = $this->Email->to();
		$this->assertEquals($configs->test['to'], $result);

		$result = $this->Email->from();
		$this->assertEquals($configs->test['from'], $result);

		$result = $this->Email->subject();
		$this->assertEquals($configs->test['subject'], $result);

		$result = $this->Email->transport();
		$this->assertEquals($configs->test['transport'], $result);

		$result = $this->Email->transportClass();
		$this->assertTrue($result instanceof DebugTransport);

		$result = $this->Email->send('This is the message');

		$this->assertTrue((bool)strpos($result['headers'], 'Message-ID: '));
		$this->assertTrue((bool)strpos($result['headers'], 'To: '));
	}

/**
 * testViewRender method
 *
 * @return void
 */
	public function testViewRender() {
		$result = $this->Email->viewRender();
		$this->assertEquals('View', $result);

		$result = $this->Email->viewRender('Theme');
		$this->assertInstanceOf('Email', $result);

		$result = $this->Email->viewRender();
		$this->assertEquals('Theme', $result);
	}

/**
 * testEmailFormat method
 *
 * @return void
 */
	public function testEmailFormat() {
		$result = $this->Email->emailFormat();
		$this->assertEquals('text', $result);

		$result = $this->Email->emailFormat('html');
		$this->assertInstanceOf('Email', $result);

		$result = $this->Email->emailFormat();
		$this->assertEquals('html', $result);

		$this->setExpectedException('SocketException');
		$result = $this->Email->emailFormat('invalid');
	}

/**
 * Tests that it is possible to add charset configuration to a Email object
 *
 * @return void
 */
	public function testConfigCharset() {
		$email = new Email();
		$this->assertEquals(Configure::read('App.encoding'), $email->charset);
		$this->assertEquals(Configure::read('App.encoding'), $email->headerCharset);

		$email = new Email(array('charset' => 'iso-2022-jp', 'headerCharset' => 'iso-2022-jp-ms'));
		$this->assertEquals('iso-2022-jp', $email->charset);
		$this->assertEquals('iso-2022-jp-ms', $email->headerCharset);

		$email = new Email(array('charset' => 'iso-2022-jp'));
		$this->assertEquals('iso-2022-jp', $email->charset);
		$this->assertEquals('iso-2022-jp', $email->headerCharset);

		$email = new Email(array('headerCharset' => 'iso-2022-jp-ms'));
		$this->assertEquals(Configure::read('App.encoding'), $email->charset);
		$this->assertEquals('iso-2022-jp-ms', $email->headerCharset);
	}

/**
 * Tests that the header is encoded using the configured headerCharset
 *
 * @return void
 */
	public function testHeaderEncoding() {
		$this->skipIf(!function_exists('mb_convert_encoding'));
		$email = new Email(array('headerCharset' => 'iso-2022-jp-ms', 'transport' => 'Debug'));
		$email->subject('あれ？もしかしての前と');
		$headers = $email->getHeaders(array('subject'));
		$expected = "?ISO-2022-JP?B?GyRCJCIkbCEpJGIkNyQrJDckRiROQTAkSBsoQg==?=";
		$this->assertContains($expected, $headers['Subject']);

		$email->to('someone@example.com')->from('someone@example.com');
		$result = $email->send('ってテーブルを作ってやってたらう');
		$this->assertContains('ってテーブルを作ってやってたらう', $result['message']);
	}

/**
 * Tests that the body is encoded using the configured charset
 *
 * @return void
 */
	public function testBodyEncoding() {
		$this->skipIf(!function_exists('mb_convert_encoding'));
		$email = new Email(array(
			'charset' => 'iso-2022-jp',
			'headerCharset' => 'iso-2022-jp-ms',
			'transport' => 'Debug'
		));
		$email->subject('あれ？もしかしての前と');
		$headers = $email->getHeaders(array('subject'));
		$expected = "?ISO-2022-JP?B?GyRCJCIkbCEpJGIkNyQrJDckRiROQTAkSBsoQg==?=";
		$this->assertContains($expected, $headers['Subject']);

		$email->to('someone@example.com')->from('someone@example.com');
		$result = $email->send('ってテーブルを作ってやってたらう');
		$this->assertContains('Content-Type: text/plain; charset=ISO-2022-JP', $result['headers']);
		$this->assertContains(mb_convert_encoding('ってテーブルを作ってやってたらう','ISO-2022-JP'), $result['message']);
	}

/**
 * Tests that the body is encoded using the configured charset (Japanese standard encoding)
 *
 * @return void
 */
	public function testBodyEncodingIso2022Jp() {
		$this->skipIf(!function_exists('mb_convert_encoding'));
		$email = new Email(array(
			'charset' => 'iso-2022-jp',
			'headerCharset' => 'iso-2022-jp',
			'transport' => 'Debug'
		));
		$email->subject('あれ？もしかしての前と');
		$headers = $email->getHeaders(array('subject'));
		$expected = "?ISO-2022-JP?B?GyRCJCIkbCEpJGIkNyQrJDckRiROQTAkSBsoQg==?=";
		$this->assertContains($expected, $headers['Subject']);

		$email->to('someone@example.com')->from('someone@example.com');
		$result = $email->send('①㈱');
		$this->assertTextContains("Content-Type: text/plain; charset=ISO-2022-JP", $result['headers']);
		$this->assertTextNotContains("Content-Type: text/plain; charset=ISO-2022-JP-MS", $result['headers']); // not charset=iso-2022-jp-ms
		$this->assertTextNotContains(mb_convert_encoding('①㈱','ISO-2022-JP-MS'), $result['message']);
	}

/**
 * Tests that the body is encoded using the configured charset (Japanese irregular encoding, but sometime use this)
 *
 * @return void
 */
	public function testBodyEncodingIso2022JpMs() {
		$this->skipIf(!function_exists('mb_convert_encoding'));
		$email = new Email(array(
			'charset' => 'iso-2022-jp-ms',
			'headerCharset' => 'iso-2022-jp-ms',
			'transport' => 'Debug'
		));
		$email->subject('あれ？もしかしての前と');
		$headers = $email->getHeaders(array('subject'));
		$expected = "?ISO-2022-JP?B?GyRCJCIkbCEpJGIkNyQrJDckRiROQTAkSBsoQg==?=";
		$this->assertContains($expected, $headers['Subject']);

		$email->to('someone@example.com')->from('someone@example.com');
		$result = $email->send('①㈱');
		$this->assertTextContains("Content-Type: text/plain; charset=ISO-2022-JP", $result['headers']);
		$this->assertTextNotContains("Content-Type: text/plain; charset=iso-2022-jp-ms", $result['headers']); // not charset=iso-2022-jp-ms
		$this->assertContains(mb_convert_encoding('①㈱','ISO-2022-JP-MS'), $result['message']);
	}

	protected function _checkContentTransferEncoding($message, $charset) {
		$boundary = '--alt-' . $this->Email->getBoundary();
		$result['text'] = false;
		$result['html'] = false;
		$length = count($message);
		for ($i = 0; $i < $length; ++$i) {
			if ($message[$i] == $boundary) {
				$flag = false;
				$type = '';
				while (!preg_match('/^$/', $message[$i])) {
					if (preg_match('/^Content-Type: text\/plain/', $message[$i])) {
						$type = 'text';
					}
					if (preg_match('/^Content-Type: text\/html/', $message[$i])) {
						$type = 'html';
					}
					if ($message[$i] === 'Content-Transfer-Encoding: ' . $charset) {
						$flag = true;
					}
					++$i;
				}
				$result[$type] = $flag;
			}
		}
		return $result['text'] && $result['html'];
	}

/**
 * Test Email::_encode function
 *
 * @return void
 */
	public function testEncode() {
		$this->skipIf(!function_exists('mb_convert_encoding'));

		$this->Email->headerCharset = 'ISO-2022-JP';
		$result = $this->Email->encode('日本語');
		$expected = '=?ISO-2022-JP?B?GyRCRnxLXDhsGyhC?=';
		$this->assertSame($expected, $result);

		$this->Email->headerCharset = 'ISO-2022-JP';
		$result = $this->Email->encode('長い長い長いSubjectの場合はfoldingするのが正しいんだけどいったいどうなるんだろう？');
		$expected = "=?ISO-2022-JP?B?GyRCRDkkJEQ5JCREOSQkGyhCU3ViamVjdBskQiROPmw5ZyRPGyhCZm9s?=\r\n" .
			" =?ISO-2022-JP?B?ZGluZxskQiQ5JGskTiQsQDUkNyQkJHMkQCQxJEkkJCRDJD8kJCRJGyhC?=\r\n" .
			" =?ISO-2022-JP?B?GyRCJCYkSiRrJHMkQCRtJCYhKRsoQg==?=";
		$this->assertSame($expected, $result);
	}

/**
 * Tests charset setter/getter
 *
 * @return void
 */
	public function testCharset() {
		$this->Email->charset('UTF-8');
		$this->assertSame($this->Email->charset(), 'UTF-8');

		$this->Email->charset('ISO-2022-JP');
		$this->assertSame($this->Email->charset(), 'ISO-2022-JP');

		$charset = $this->Email->charset('Shift_JIS');
		$this->assertSame($charset, 'Shift_JIS');
	}

/**
 * Tests headerCharset setter/getter
 *
 * @return void
 */
	public function testHeaderCharset() {
		$this->Email->headerCharset('UTF-8');
		$this->assertSame($this->Email->headerCharset(), 'UTF-8');

		$this->Email->headerCharset('ISO-2022-JP');
		$this->assertSame($this->Email->headerCharset(), 'ISO-2022-JP');

		$charset = $this->Email->headerCharset('Shift_JIS');
		$this->assertSame($charset, 'Shift_JIS');
	}

/**
 * Tests for compatible check.
 *          charset property and       charset() method.
 *    headerCharset property and headerCharset() method.
 */
	public function testCharsetsCompatible() {
		$this->skipIf(!function_exists('mb_convert_encoding'));

		$checkHeaders = array(
			'from' => true,
			'to' => true,
			'cc' => true,
			'subject' => true,
		);

		// Header Charset : null (used by default UTF-8)
		//   Body Charset : ISO-2022-JP
		$oldStyleEmail = $this->_getEmailByOldStyleCharset('iso-2022-jp', null);
		$oldStyleHeaders = $oldStyleEmail->getHeaders($checkHeaders);

		$newStyleEmail = $this->_getEmailByNewStyleCharset('iso-2022-jp', null);
		$newStyleHeaders = $newStyleEmail->getHeaders($checkHeaders);

		$this->assertSame($oldStyleHeaders['From'],    $newStyleHeaders['From']);
		$this->assertSame($oldStyleHeaders['To'],      $newStyleHeaders['To']);
		$this->assertSame($oldStyleHeaders['Cc'],      $newStyleHeaders['Cc']);
		$this->assertSame($oldStyleHeaders['Subject'], $newStyleHeaders['Subject']);

		// Header Charset : UTF-8
		//   Boby Charset : ISO-2022-JP
		$oldStyleEmail = $this->_getEmailByOldStyleCharset('iso-2022-jp', 'utf-8');
		$oldStyleHeaders = $oldStyleEmail->getHeaders($checkHeaders);

		$newStyleEmail = $this->_getEmailByNewStyleCharset('iso-2022-jp', 'utf-8');
		$newStyleHeaders = $newStyleEmail->getHeaders($checkHeaders);

		$this->assertSame($oldStyleHeaders['From'],    $newStyleHeaders['From']);
		$this->assertSame($oldStyleHeaders['To'],      $newStyleHeaders['To']);
		$this->assertSame($oldStyleHeaders['Cc'],      $newStyleHeaders['Cc']);
		$this->assertSame($oldStyleHeaders['Subject'], $newStyleHeaders['Subject']);

		// Header Charset : ISO-2022-JP
		//   Boby Charset : UTF-8
		$oldStyleEmail = $this->_getEmailByOldStyleCharset('utf-8', 'iso-2022-jp');
		$oldStyleHeaders = $oldStyleEmail->getHeaders($checkHeaders);

		$newStyleEmail = $this->_getEmailByNewStyleCharset('utf-8', 'iso-2022-jp');
		$newStyleHeaders = $newStyleEmail->getHeaders($checkHeaders);

		$this->assertSame($oldStyleHeaders['From'],    $newStyleHeaders['From']);
		$this->assertSame($oldStyleHeaders['To'],      $newStyleHeaders['To']);
		$this->assertSame($oldStyleHeaders['Cc'],      $newStyleHeaders['Cc']);
		$this->assertSame($oldStyleHeaders['Subject'], $newStyleHeaders['Subject']);
	}

	protected function _getEmailByOldStyleCharset($charset, $headerCharset) {
		$email = new Email(array('transport' => 'Debug'));

		if (! empty($charset)) {
			$email->charset = $charset;
		}
		if (! empty($headerCharset)) {
			$email->headerCharset = $headerCharset;
		}

		$email->from('someone@example.com', 'どこかの誰か');
		$email->to('someperson@example.jp', 'どこかのどなたか');
		$email->cc('miku@example.net', 'ミク');
		$email->subject('テストメール');
		$email->send('テストメールの本文');

		return $email;
	}

	protected function _getEmailByNewStyleCharset($charset, $headerCharset) {
		$email = new Email(array('transport' => 'Debug'));

		if (! empty($charset)) {
			$email->charset($charset);
		}
		if (! empty($headerCharset)) {
			$email->headerCharset($headerCharset);
		}

		$email->from('someone@example.com', 'どこかの誰か');
		$email->to('someperson@example.jp', 'どこかのどなたか');
		$email->cc('miku@example.net', 'ミク');
		$email->subject('テストメール');
		$email->send('テストメールの本文');

		return $email;
	}

}
