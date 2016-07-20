<?php
namespace REST;

use FunctionalTester;

class NetworkOptionsCest {

	public function _before( FunctionalTester $I ) {
	}

	public function _after( FunctionalTester $I ) {
	}

	/**
	 * @test
	 * it should mark bad request if trying to update lang_id for non existing blog_id
	 */
	public function it_should_mark_bad_request_if_trying_to_update_lang_id_for_non_existing_blog_id( FunctionalTester $I ) {
		$I->loginAsAdmin();
		$I->amOnAdminPage( '/network/settings.php?page=tongues-network-options' );
		$I->haveHttpHeader( 'X-WP-Nonce', $I->grabValueFrom( 'input[name="tongues-nonce"]' ) );
		$I->sendAjaxPostRequest( '/wp-json/tongues/v1/network-config', [
			[ 'blog_id' => 21, 'lang_id' => 23 ]
		] );

		$I->canSeeResponseCodeIs( '400' );
	}
}
