<?php
/**
 * ModelTest file
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
 * @package       Cake.Test.Case.Model
 * @since         CakePHP(tm) v 1.2.0.4206
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace lib\Cake\Test\Case\Model;


require_once dirname(__FILE__) . DS . 'models.php';

/**
 * ModelBaseTest
 *
 * @package       Cake.Test.Case.Model
 */
abstract class BaseModelTest extends TestCase {

/**
 * autoFixtures property
 *
 * @var bool false
 */
	public $autoFixtures = false;

/**
 * Whether backup global state for each test method or not
 *
 * @var bool false
 */
	public $backupGlobals = false;

/**
 * fixtures property
 *
 * @var array
 */
	public $fixtures = array(
		'core.categories',
		'core.category_threads',
		'core.users',
		'core.my_categories',
		'core.my_products',
		'core.my_users',
		'core.my_categories_my_users',
		'core.my_categories_my_products',
		'core.articles',
		'core.featureds',
		'core.article_featureds_tags',
		'core.article_featureds',
		'core.numeric_articles',
		'core.tags',
		'core.articles_tags',
		'core.comments',
		'core.attachments',
		'core.apples',
		'core.samples',
		'core.another_articles',
		'core.items',
		'core.advertisements',
		'core.homes',
		'core.posts',
		'core.authors',
		'core.bids',
		'core.portfolios',
		'core.products',
		'core.projects',
		'core.threads',
		'core.messages',
		'core.items_portfolios',
		'core.syfiles',
		'core.images',
		'core.device_types',
		'core.device_type_categories',
		'core.feature_sets',
		'core.exterior_type_categories',
		'core.documents',
		'core.devices',
		'core.document_directories',
		'core.primary_models',
		'core.secondary_models',
		'core.somethings',
		'core.something_elses',
		'core.join_things',
		'core.join_as',
		'core.join_bs',
		'core.join_cs',
		'core.join_a_bs',
		'core.join_a_cs',
		'core.uuids',
		'core.data_tests',
		'core.posts_tags',
		'core.the_paper_monkies',
		'core.people',
		'core.underscore_fields',
		'core.nodes',
		'core.dependencies',
		'core.stories',
		'core.stories_tags',
		'core.cds',
		'core.books',
		'core.baskets',
		'core.overall_favorites',
		'core.accounts',
		'core.contents',
		'core.content_accounts',
		'core.film_files',
		'core.test_plugin_articles',
		'core.test_plugin_comments',
		'core.uuiditems',
		'core.counter_cache_users',
		'core.counter_cache_posts',
		'core.counter_cache_user_nonstandard_primary_keys',
		'core.counter_cache_post_nonstandard_primary_keys',
		'core.uuidportfolios',
		'core.uuiditems_uuidportfolios',
		'core.uuiditems_uuidportfolio_numericids',
		'core.fruits',
		'core.fruits_uuid_tags',
		'core.uuid_tags',
		'core.product_update_alls',
		'core.group_update_alls',
		'core.players',
		'core.guilds',
		'core.guilds_players',
		'core.armors',
		'core.armors_players',
		'core.biddings',
		'core.bidding_messages',
		'core.sites',
		'core.domains',
		'core.domains_sites'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->debug = Configure::read('debug');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		Configure::write('debug', $this->debug);
		ClassRegistry::flush();
	}
}
