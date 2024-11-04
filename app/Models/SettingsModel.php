<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    public function updatePrivacySettings($userId, $data) {
        $db = \Config\Database::connect();
        $builder = $db->table('user_privacy');

        if ($builder->where('user_id', $userId)->countAllResults() > 0) {
            return $builder->where('user_id', $userId)->set($data)->update();
        } else {
            $data['user_id'] = $userId;
            return $builder->insert($data);
        }
    }

    public function getPrivacySettings($userId) {
        $db = \Config\Database::connect();
        $builder = $db->table('user_privacy');

        $result = $builder->select('sharing, budget_visibility, net_worth_visibility')
                        ->where('user_id', $userId)
                        ->get()
                        ->getRowArray();

        // Default values
        return $result ?? [
            'sharing' => 0,
            'budget_visibility' => 0,
            'net_worth_visibility' => 0,
        ];
    }
}

?>