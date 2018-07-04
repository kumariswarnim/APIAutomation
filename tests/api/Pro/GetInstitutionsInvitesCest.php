<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GetInstitutionsInvitesCest
{
    public function testGetInstitutionsInvitesSuccess(ApiTester $I){
        $I->wantToTest('BusuuPRO - valid request from admin user to GET the list of invites in an institution');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getInstitutionInvites(Pro::INSTITUTION_ID,200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getInstitutionInvites'));
    }

    public function testGetInstitutionsInvitesForbidden(ApiTester $I){
        $I->wantToTest('BusuuPRO - invalid request from admin user to GET the list of invites in an institution, forbidden');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getInstitutionInvites(Pro::OTHER_INSTITUTION_ID,403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testGetInstitutionsInvitesUrlNotFound(ApiTester $I){
        $I->wantToTest('BusuuPRO - invalid request from admin user to GET the list of invites in an institution, url not found');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getInstitutionInvites(1000000,404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}