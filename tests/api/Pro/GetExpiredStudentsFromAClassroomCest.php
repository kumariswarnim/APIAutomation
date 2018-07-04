<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GetExpiredStudentsFromAClassroomCest
{
    /**
     * @group ProdOnly
     */
    public function testGetExpiredStudentsFromAClassroomSuccessOnProduction(ApiTester $I){
        $I->wantToTest('BusuuPRO - valid request from admin user to GET the list of expired students of a classroom, production');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getExpiredStudentsFromAClassroom(Pro::CLASSROOM_ID_PRODUCTION, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getExpiredStudentsFromAClassroom'));
    }

    /**
     * @group IntOnly
     */
    public function testGetExpiredStudentsFromAClassroomSuccessOnIntegration(ApiTester $I){
        $I->wantToTest('BusuuPRO - valid request from admin user to GET the list of expired students of a classroom, integration');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getExpiredStudentsFromAClassroom(Pro::CLASSROOM_ID_INTEGRATION, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getExpiredStudentsFromAClassroom'));
    }

    public function testGetExpiredStudentsFromAClassroomForbidden(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid admin request to GET all the expired students of a classroom where access is not granted, forbidden');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getExpiredStudentsFromAClassroom(951, 403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testGetExpiredStudentsFromAClassroomUrlNotFound(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid admin request to GET all the expired students of an invalid classroom, url not found');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getExpiredStudentsFromAClassroom(1000000, 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}