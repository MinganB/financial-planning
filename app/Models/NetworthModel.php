<?php

namespace App\Models;

use CodeIgniter\Model;

class NetworthModel extends Model
{
    /**
     * Fetches the given user's current assets with their latest values.
     * @param int $userId Id of the user
     * 
     * @return array Results array (empty if no results)
     */
    public function getUserCurrentAssets($userId) {
        $db = \Config\Database::connect();

        $assetsQuery = $db->table('nw_assets AS a')
            ->select('a.asset_id, a.name, a.notes, a.category_id, v.market_value AS value, v.value_date')
            ->join('(SELECT asset_id, MAX(value_date) AS latest_value_date FROM nw_asset_values GROUP BY asset_id) AS latest', 'a.asset_id = latest.asset_id')
            ->join('nw_asset_values AS v', 'a.asset_id = v.asset_id AND v.value_date = latest.latest_value_date')
            ->where('a.user_id', $userId)
            ->get();

        return $assetsQuery->getResultArray();
    }

    /**
     * Fetches the given user's current liabilities with their latest values.
     * @param int $userId Id of the user
     * 
     * @return array Results array (empty if no results)
     */
    public function getUserCurrentLiabilities($userId) {
        $db = \Config\Database::connect();

        $liabilitiesQuery = $db->table('nw_liabilities AS l')
            ->select('l.liability_id, l.name, l.notes, l.category_id, v.value AS value, v.value_date')
            ->join('(SELECT liability_id, MAX(value_date) AS latest_value_date FROM nw_liability_values GROUP BY liability_id) AS latest', 'l.liability_id = latest.liability_id')
            ->join('nw_liability_values AS v', 'l.liability_id = v.liability_id AND v.value_date = latest.latest_value_date')
            ->where('l.user_id', $userId)
            ->get();

        return $liabilitiesQuery->getResultArray();
    }

    /**
     * Deletes an asset with a given Id. Asset must be owned by the user Id provided.
     * @param int $userId ID of user owning the asset
     * @param int $assetId ID of the asset to delete
     * 
     * @return bool True if an asset was deleted, false if asset not found or not owned by user.
     */
    public function deleteAssetById($userId, $assetId) {
        // Confirm asset belongs to user
        $asset = $this->db->table('nw_assets')
                          ->where('asset_id', $assetId)
                          ->where('user_id', $userId)
                          ->get()
                          ->getRow();
    
        if ($asset) {
            // Delete values hisotry
            $this->db->table('nw_asset_values')
                     ->where('asset_id', $assetId)
                     ->delete();
    
            // Delete asset
            $this->db->table('nw_assets')
                     ->where('asset_id', $assetId)
                     ->where('user_id', $userId)
                     ->delete();
    
            return true;
        } else {
            return false;
        }
    }  

    /**
     * Deletes a liability with a given Id. Liability must be owned by the user Id provided.
     * @param int $userId ID of user owning the liability
     * @param int $liabilityId ID of the liability to delete
     * 
     * @return bool True if an liability was deleted, false otherwise.
     */
    public function deleteLiabilityById($userId, $liabilityId) {
        // Confirm liability belongs to user
        $liability = $this->db->table('nw_liabilities')
                          ->where('liability_id', $liabilityId)
                          ->where('user_id', $userId)
                          ->get()
                          ->getRow();
    
        // If liability exists and belongs to  user, proceed
        if ($liability) {
            // Delete value hisotry
            $this->db->table('nw_liability_values')
                     ->where('liability_id', $liabilityId)
                     ->delete();
    
            // Delete liability
            $this->db->table('nw_liabilities')
                     ->where('liability_id', $liabilityId)
                     ->where('user_id', $userId)
                     ->delete();
    
            return true;
        } else {
            return false; // Liability not found or not owned by user
        }
    }  
    
    /**
     * Create a new asset for a user and log its initial market value.
     * 
     * @param int $userId The ID of the user who owns the asset.
     * @param string $name The name of the asset.
     * @param float $value The current market value of the asset as a decimal float (e.g., 100000.00).
     * @param int $categoryId The ID of the asset category.
     * @param string $description Notes or additional information.
     * 
     * @return int|bool The ID of the newly created asset if successful, or false if failed.
     */
    public function createAsset($userId, $name, $value, $categoryId, $description) {
        $db = \Config\Database::connect();

        $db->transStart();
    
        $assetData = [
            'user_id'    => $userId,
            'name'       => $name,
            'notes'      => $description,
            'category_id'=> $categoryId
        ];
        $db->table('nw_assets')->insert($assetData);
    
        $assetId = $db->insertID();
    
        $valueData = [
            'asset_id'     => $assetId,
            'market_value' => $value,
            'value_date'   => date('Y-m-d') // Use the current date
        ];
    
        $db->table('nw_asset_values')->insert($valueData);
    
        $db->transComplete();
    
        if ($db->transStatus() === FALSE) {
            return false;
        }
    
        // Return inserted asset ID
        return $assetId;
    }    

    /**
     * Update an existing asset for a user
     * 
     * @param int $userId ID of user owning the asset
     * @param int $assetId ID of the asset to update
     * @param string $name Updated name of the asset
     * @param int $categoryId Updated ID of the asset category
     * @param string $description Updated asset notes / description
     * @param float|null $value (Optional) New market value of the asset.
     * 
     * @return bool Whether the update was successful or not
     */
    public function updateAsset($userId, $assetId, $name, $categoryId, $description, $value = null) {
        $db = \Config\Database::connect();

        $db->transStart();

        // Update in nw_assets
        $assetData = [
            'name'       => $name,
            'notes'      => $description,
            'category_id'=> $categoryId
        ];

        $db->table('nw_assets')
            ->where('asset_id', $assetId)
            ->where('user_id', $userId)
            ->update($assetData);

        if ($value !== null) {
            $valueDate = date('Y-m-d'); // Use current date

            $existingValue = $db->table('nw_asset_values')
                ->where('asset_id', $assetId)
                ->where('value_date', $valueDate)
                ->get()
                ->getRow();

            if($existingValue) {
                // Update
                $db->table('nw_asset_values')
                    ->where('asset_id', $assetId)
                    ->where('value_date', $valueDate)
                    ->update(['market_value' => $value]);
            } else {
                // Insert
                $valueData = [
                    'asset_id' => $assetId,
                    'market_value' => $value,
                    'value_date' => $valueDate
                ];
    
                $db->table('nw_asset_values')->insert($valueData);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return false;
        }

        return true;
    }

    /**
     * Create a new liability for a user and log its balance.
     * 
     * @param int $userId User who owns the liability.
     * @param string $name The name of the liability.
     * @param float $value The current balance of the liability as a decimal float (e.g., 100000.00).
     * @param int $categoryId The ID of the liability category.
     * @param string $description Notes or additional information about the debt.
     * 
     * @return int|bool The ID of the newly created liability if successful, or false if failed.
     */
    public function createLiability($userId, $name, $value, $categoryId, $description) {
        $db = \Config\Database::connect();

        $db->transStart();
    
        $LiabilityData = [
            'user_id'    => $userId,
            'name'       => $name,
            'notes'      => $description,
            'category_id'=> $categoryId
        ];
        $db->table('nw_liabilities')->insert($LiabilityData);
    
        $liabilityId = $db->insertID();
    
        $valueData = [
            'liability_id'     => $liabilityId,
            'value' => $value,
            'value_date'   => date('Y-m-d') // Use the current date
        ];
    
        $db->table('nw_liability_values')->insert($valueData);
    
        $db->transComplete();
    
        if ($db->transStatus() === FALSE) {
            return false;
        }
    
        // Return inserted asset ID
        return $liabilityId;
    }  

    /**
     * Update a liability for the given user.
     * 
     * @param int $userId User who owns the liability.
     * @param int $liabilityId Liability to edit.
     * @param string $name Updated liability name.
     * @param int $categoryId Updated liability category.
     * @param string $description Updated liability description/notes.
     * @param float|null $value (Optional) Updated liability value.
     */
    public function updateLiability($userId, $liabilityId, $name, $categoryId, $description, $value = null) {
        $db = \Config\Database::connect();

        $db->transStart();

        // Update in nw_liabilities
        $liabilityData = [
            'name'       => $name,
            'notes'      => $description,
            'category_id'=> $categoryId
        ];

        $db->table('nw_liabilities')
            ->where('liability_id', $liabilityId)
            ->where('user_id', $userId)
            ->update($liabilityData);

        // Insert updated value into nw_liability_values
        if ($value !== null) {
            $valueDate = date('Y-m-d'); // Use current date

            $existingValue = $db->table('nw_liability_values')
                ->where('liability_id', $liabilityId)
                ->where('value_date', $valueDate)
                ->get()
                ->getRow();

            if($existingValue) {
                // Update
                $db->table('nw_liability_values')
                    ->where('liability_id', $liabilityId)
                    ->where('value_date', $valueDate)
                    ->update(['value' => $value]);
            } else {
                // Insert
                $valueData = [
                    'liability_id' => $liabilityId,
                    'value' => $value,
                    'value_date' => $valueDate
                ];
    
                $db->table('nw_liability_values')->insert($valueData);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return false;
        }

        return true;
    }
}