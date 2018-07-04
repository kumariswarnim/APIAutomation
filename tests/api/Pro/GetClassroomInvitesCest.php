<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GetClassroomInvitesCest
{
    /**
     * @group ProdOnly
     */
    public function testGetClassroomInvitesSuccessOnProduction(ApiTester $I){
        $I->wantToTest('BusuuPRO - valid admin request to GET all the invites of a classroom');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getClassroomInvites(Pro::CLASSROOM_ID_PRODUCTION,200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getClassroomInvites'));
    }

    /**
     * @group IntOnly
     */
    public function testGetClassroomInvitesSuccessOnIntegration(ApiTester $I){
        $I->wantToTest('BusuuPRO - valid admin request to GET all the invites of a classroom');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getClassroomInvites(Pro::CLASSROOM_ID_INTEGRATION,200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getClassroomInvites'));
    }

    public function testGetClassroomInvitesForbidden(ApiTester $I){
        $I->wantToTest('BusuuPRO - invalid admin request to GET all the invites of a classroom where access is not granted, forbidden');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getClassroomInvites(951,403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testGetClassroomInvitesUrlNotFound(ApiTester $I){
        $I->wantToTest('BusuuPRO - invalid admin request to GET all the invites of an invalid classroom, url not found');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getClassroomInvites(1000000,404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}