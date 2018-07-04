<?php

namespace Module;

class Pro extends AbstractModule
{
    /**
     * Sends a get request to retrieve a list of students in a busuu Pro institution and validates response code
     *
     * @param $institutionId
     * @param $responseCode
     */
    public function getProStudents($institutionId, $responseCode)
    {
        $this->sendGetAndCheckResponse("/institutions/$institutionId/students", $responseCode);
    }

    /**
     * Sends a get request to retrieve a list of instructors in a busuu Pro institution and validates response code
     *
     * @param $institutionId
     * @param $responseCode
     */
    public function getProInstitutionInstructors($institutionId, $responseCode)
    {
        $this->sendGetAndCheckResponse("/institutions/$institutionId/instructors", $responseCode);
    }

    /**
     * Sends a get request to retrieve instructors for a given classroom
     *
     * @param $classroomId
     * @param $responseCode
     */
    public function getProClassroomInstructors($classroomId, $responseCode)
    {
        $this->sendGetAndCheckResponse("/classrooms/$classroomId/instructors", $responseCode);
    }

    /**
     * Sends a get request to retrieve all the data needed for the busuu Pro report tab and validates response code
     *
     * @param $institutionId
     * @param $responseCode
     */
    public function getProReport($institutionId, $responseCode)
    {
        $this->sendGetAndCheckResponse("/institutions/$institutionId/report", $responseCode);
    }

    /**
     * Sends a get request to retrieve all busuu Pro institutions and validates the response code
     *
     * @param $responseCode
     */
    public function getAllProInstitutions($responseCode)
    {
        $this->sendGetAndCheckResponse("/institutions", $responseCode);
    }

    /**
     * Sends a get request to retrieve all admins of a Pro institution and validates response code
     *
     * @param $institutionId
     * @param $responseCode
     */
    public function getProInstitutionAdmins($institutionId, $responseCode)
    {
        $this->sendGetAndCheckResponse("/institutions/$institutionId/admins", $responseCode);
    }

    /**
     * Sends a get request to retrieve classrooms of a Pro institution and validates response code
     *
     * @param $institutionId
     * @param $role
     * @param $responseCode
     */
    public function getProInstitutionClassrooms($institutionId, $role, $responseCode)
    {
        $this->sendGetAndCheckResponse("/institutions/$institutionId/classrooms?role=$role", $responseCode);
    }

    /**
     * Sends a post request to create a new busuu Pro classroom in an institution
     *
     * @param $institutionId
     * @param $requestParams
     * @param $responseCode
     */
    public function createProClassroom($institutionId, $requestParams, $responseCode)
    {
        $this->sendPostAndCheckResponse("/institutions/$institutionId/classrooms", $requestParams, $responseCode);
    }

    /**
     * Sends a request to delete a busuu Pro classroom
     *
     * @param $classroomId
     * @param $responseCode
     */
    public function deleteProClassroom($classroomId, $responseCode)
    {
        $this->sendDeleteAndCheckResponse("/classrooms/$classroomId", $responseCode);
    }

    /**
     * Sends a get request to retrieve invites of a Pro classroom and validates response code
     *
     * @param $classroomId
     * @param $responseCode
     */
    public function getClassroomInvites($classroomId, $responseCode)
    {
        $this->sendGetAndCheckResponse("/classrooms/$classroomId/invites", $responseCode);
    }

    /**
     * Sends a get request to retrieve invites of a Pro classroom and validates response code
     *
     * @param $institutionId
     * @param $responseCode
     */
    public function getInstitutionInvites($institutionId, $responseCode)
    {
        $this->sendGetAndCheckResponse("/institutions/$institutionId/invites", $responseCode);
    }
  
    /**
     * Sends a get request to retrieve list of students of a Pro classroom and validates response code
     *
     * @param $classroomId
     * @param $responseCode
     */
    public function getProClassroomStudents($classroomId, $responseCode)
    {
        $this->sendGetAndCheckResponse("/classrooms/$classroomId/students", $responseCode);
    }

    /**
     * Sends a get request to retrieve list of expired students of a Pro institution and validates response code
     *
     * @param $institutionId
     * @param $responseCode
     */

    public function getExpiredStudentsFromInstitution($institutionId, $responseCode)
    {
        $this->sendGetAndCheckResponse("/institutions/$institutionId/students/expired", $responseCode);
    }

    /**
     * Sends a get request to retrieve a specific Pro institution and validates response code
     *
     * @param $institutionId
     * @param $responseCode
     */
    public function getASpecificProInstitution($institutionId, $responseCode)
    {
        $this->sendGetAndCheckResponse("/institutions/$institutionId", $responseCode);
    }

    /**
     * Sends a post request to generate a CSV file containing students of a Pro institution and validates response code
     *
     * @param $institutionId
     * @param $responseCode
     */
    public function generateStudentsCsvFileForInstitution($institutionId, $responseCode)
    {
        $this->sendPostAndCheckResponse("/institutions/$institutionId/students_csv", $params = null, $responseCode);
    }
    
    /**
     * Sends a get request to retrieve the list of expired students of a classroom and validates response code
     *
     * @param $classroomId
     * @param $responseCode
     */
    public function getExpiredStudentsFromAClassroom($classroomId, $responseCode)
    {
        $this->sendGetAndCheckResponse("/classrooms/$classroomId/students/expired", $responseCode);
    }
}