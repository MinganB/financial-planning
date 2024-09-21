<?php

if (!function_exists('updateDataInDB')) {
    /**
     * Updates data user data in a given DB table.
     * 
     * @param string $table Name of the table to update data fields in.
     * @param int $userId user id of the user to update data for.
     * @param array $data Array of data to update with columns as keys.
     * @return bool True on success, false on failure
     */
    function updateDataInDB($table, $userId, $data, $allowedFields = null) {
        log_message('info', json_encode([$table, $userId, $data, $allowedFields]));
        $tableNames = ['user_data', 'user_details', 'user_employment', 'user_underwriting'];

        if($allowedFields !== null)
            $data = array_intersect_key($data, array_flip($allowedFields));

        if(!$table || !in_array($table, $tableNames)) {
            log_message('error', 'updateDataInDB failed: '.json_encode($table).' is not a valid user data table.');
            return false;
        }

        if (empty($data)){
            log_message('error', 'updateDataInDB failed: No valid data fields provided to update.');
            return false;
        } 
        
        if(!$userId || !is_int($userId)) {
            log_message('error', 'updateDataInDB failed: Invalid user id ('.json_encode($userId).')');
            return false;
        }

        $db = \Config\Database::connect();
        $builder = $db->table($table);

        $data['user_id'] = $userId;
        $existingRecord = $builder->where('user_id', $userId)->get()->getRow();

        if ($existingRecord) {
            $builder->where('user_id', $userId);
            $result = $builder->update($data);
        } else {
            $result = $builder->insert($data);
        }

        return $result !== false;
    }
}

?>