<?php
namespace REST;

use FunctionalTester;

class NetworkOptionsCest
{

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * @test
     * it should mark bad request if trying to update lang_id for non existing blog_id
     */
    public function it_should_mark_bad_request_if_trying_to_update_lang_id_for_non_existing_blog_id(FunctionalTester $I)
    {
        $I->loginAsAdmin();
        $I->amOnAdminPage('/network/settings.php?page=tongues-network-options');
        $I->haveHttpHeader('X-WP-Nonce', $I->grabValueFrom('input[name="tongues-nonce"]'));
        $I->sendAjaxPostRequest('/wp-json/tongues/v1/network-settings', [
            'lang_ids' => [
                ['blog_id' => 21, 'lang_id' => 23]
            ]
        ]);

        $I->canSeeResponseCodeIs('400');
    }

    /**
     * @test
     * it should update an existing blog lang_id
     */
    public function it_should_update_an_existing_blog_lang_id(FunctionalTester $I)
    {
        $I->loginAsAdmin();
        $I->amOnAdminPage('/network/settings.php?page=tongues-network-options');
        $I->haveHttpHeader('X-WP-Nonce', $I->grabValueFrom('input[name="tongues-nonce"]'));
        $I->sendAjaxPostRequest('/wp-json/tongues/v1/network-settings', [
            'lang_ids' => [
                ['blog_id' => 2, 'lang_id' => 12]
            ]
        ]);

        $I->canSeeResponseCodeIs('200');
        $I->seeBlogInDatabase(['blog_id' => 2, 'lang_id' => 12]);
    }
}
