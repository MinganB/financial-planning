<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    /**
     * Update privacy settings for a user.
     * 
     * @param int $userId User to update privacy settings for.
     * @param arrat $data Array of settings to update for user with keys:
     *   - 'sharing': string (none, view, edit)
     *   - 'budget_visbility': string (private, adviser, everyone)
     *   - 'net_worth_visbility': string (private, adviser, everyone)
     * 
     * @return bool True for success, false otherwise.
     */
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

    /**
     * Get the current privacy settings for a given user.
     * 
     * @param int $userId User to update privacy settings for.
     * 
     * @return array Array of settings with keys:
     *   - 'sharing': string (none, view, edit)
     *   - 'budget_visbility': string (private, adviser, everyone)
     *   - 'net_worth_visbility': string (private, adviser, everyone)
     */
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