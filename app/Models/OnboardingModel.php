<?php

namespace App\Models;

use CodeIgniter\Model;

class OnboardingModel extends Model
{
    /**
     * Updates a user's onboarding data.
     * 
     * @param int $userId User to update data for.
     * @param array $data Array of data to update with columns as keys.
     * 
     * @return bool True if succeeded, false otherwise.
     */
    public function updateData($userId, $data) {
        helper('onboarding');
        helper('dictionary');
        helper('format');

        $user_details = [];
        $user_details_fields = getUserDetailsFields();

        $anniversary = [];
        $anniversary_fields = getAnniversaryFields();

        $user_data = [];
        $user_data_fields = getUserDataFields();

        $user_employment = [];
        $user_employment_fields = getUserEmploymentFields();

        $user_underwriting = [];
        $user_underwriting_fields = getUserUnderwritingFields();

        for ($i = 0; $i < count($data); $i++) { 
            if(isset($data[$i]->answer)) { // Verify question id and presence of an answer
                $question_id = $data[$i]->id;
                $data_type = $data[$i]->type;
                $answer = $data[$i]->answer;

                if(array_key_exists($question_id, $user_details_fields)) {
                    $user_details[$user_details_fields[$question_id]] = $answer;
                }

                if(array_key_exists($question_id, $anniversary_fields)) {
                    $anniversary[$anniversary_fields[$question_id]] = $answer;
                }

                if(array_key_exists($question_id, $user_data_fields)) {
                    $user_data[$user_data_fields[$question_id]] = $answer;

                    $question = $user_data_fields[$question_id];

                    if($question == 'home_3' && $answer != 0) {
                        $user_data['home_3'] = getProvinceByInt($answer);
                        $user_data['home_country'] = 0; // South Africa
                    }
                }

                if(array_key_exists($question_id, $user_employment_fields)) {
                    $user_employment[$user_employment_fields[$question_id]] = $answer;
                }

                if(array_key_exists($question_id, $user_underwriting_fields)) {
                    $user_underwriting[$user_underwriting_fields[$question_id]] = $answer;
                }
            }
        }

        if(array_key_exists('city', $user_data)) {
            $user_data['home_2'] = array_key_exists('home_2', $user_data) ? $user_data['home_2'] : '';
            $user_data['home_2'] = $user_data['home_2'].', '.$user_data['city'];
        }

        if(array_key_exists('street_number', $user_data)) {
            $user_data['home_1'] = array_key_exists('home_1', $user_data) ? $user_data['home_1'] : '';
            $user_data['home_1'] = $user_data['street_number'].' '.$user_data['home_1'];
        }

        if(array_key_exists('complex_name', $user_data)) {
            $user_data['home_1'] = array_key_exists('home_1', $user_data) ? $user_data['home_1'] : '';
            $user_data['home_1'] = $user_data['complex_name'].', '.$user_data['home_1'];
        }

        if(array_key_exists('complex_unit', $user_data)) {
            $user_data['home_1'] = array_key_exists('home_1', $user_data) ? $user_data['home_1'] : '';
            $user_data['home_1'] = $user_data['complex_unit'].' '.$user_data['home_1'];
        }

        if(array_key_exists('smoker_status', $user_underwriting)) {
            $user_underwriting['smoker_status'] = ($user_underwriting['is_smoker'] == 1) ? 0 : intval($user_underwriting['smoker_status']) + 1;
        }

        if(array_key_exists('alcohol_usage', $user_underwriting)) {
            $user_underwriting['alcohol_usage'] = ($user_underwriting['is_drinker'] == 1) ? 0 : intval($user_underwriting['alcohol_usage']) + 1;
        }

        if(array_key_exists('copy_postal', $user_data)) {
            if($user_data['copy_postal'] == 0) {
                $user_data['post_1'] = $user_data['home_1'];
                $user_data['post_2'] = $user_data['home_2'];
                $user_data['post_3'] = $user_data['home_3'];
                $user_data['post_country'] = $user_data['home_country'];
            }
        }

        if($anniversary['anniversary_year']) {
            $user_details['anniversary'] = $this->formatDate($anniversary['anniversary_year'], 
                                                            $anniversary['anniversary_month'], 
                                                            $anniversary['anniversary_day']);
        }

        if(count($user_details) > 0)
            $this->updateUserDetails($userId, $user_details);

        if(count($user_data) > 0)
            $this->updateUserData($userId, $user_data);

        if(count($user_employment) > 0)
            $this->updateUserEmployment($userId, $user_employment);

        if(count($user_underwriting) > 0)
            $this->updateUserUnderwriting($userId, $user_underwriting);

        return true;
    }

    /**
     * Updates user details in the user_details table based on a given array of data.
     *
     * @param int $userId User id.
     * @param array $data Array of data to update with columns as keys.
     * @return bool True if succeeded.
     */
    private function updateUserDetails($userId, $data)
    {
        $allowedFields = [
            'title',
            'nationality',
            'anniversary',
            'tax_id',
            'language',
            'gender',
            'marital_regime',
            'marital_status',
            'children_amnt',
            'home_no',
            'work_no',
            'other_no'
        ];

        helper('database');
        $result = updateDataInDB('user_details', $userId, $data, $allowedFields);

        return $result;
    }

    /**
     * Updates user underwriting data in the user_underwriting table based on a given array of data.
     *
     * @param int $userId User id.
     * @param array $data Array of data to update with columns as keys.
     * @return bool True if succeeded.
     */
    private function updateUserUnderwriting($userId, $data)
    {
        $allowedFields = [
            'medical_scheme',
            'member_no',
            'smoker_status',
            'alcohol_usage',
            'height',
            'weight',
            'bmi',
            'doctor_name',
            'doctor_practice',
            'doctor_phone',
            'qualification'
        ];

        helper('database');
        $result = updateDataInDB('user_underwriting', $userId, $data, $allowedFields);

        return $result;
    }

    /**
     * Updates user data in the user_data table based on a given array of data.
     *
     * @param int $userId User id.
     * @param array $data Array of data to update with columns as keys.
     * @return bool True if succeeded.
     */
    private function updateUserData($userId, $data)
    {
        $allowedFields = [
            'full_name',
            'last_name',
            'nick_name',
            'initials',
            'prev_surname',
            'id_number',
            'dob',
            'cell_no',
            'home_1',
            'home_2',
            'home_3',
            'home_country',
            'home_zip',
            'post_1',
            'post_2',
            'post_3',
            'post_country',
            'post_zip',
        ];

        helper('database');
        $result = updateDataInDB('user_data', $userId, $data, $allowedFields);

        return $result;
    }

    /**
     * Updates user data in the user_data table based on a given array of data.
     *
     * @param int $userId User id.
     * @param array $data Array of data to update with columns as keys.
     * @return bool True if succeeded.
     */
    private function updateUserEmployment($userId, $data)
    {
        $allowedFields = [
            'employment_status',
            'employer',
            'industry',
            'industry_since',
            'job_title',
            'job_description',
            'qualification',
            'time_allocation',
            'retirement_age',
        ];

        helper('database');
        $result = updateDataInDB('user_employment', $userId, $data, $allowedFields);

        return $result;
    }
}