<?php

namespace App\Controllers;

use App\Models\NetworthModel;

class NetworthController extends BaseController
{
    protected $netWorthModel;

    public function __construct()
    {
        $this->netWorthModel = model(NetworthModel::class);
    }

    public function index()
    {
        $userId = auth()->user()->id;
        $networthModel = $this->netWorthModel;

        $assets = $networthModel->getUserCurrentAssets($userId);
        $liabilities =$networthModel->getUserCurrentLiabilities($userId);

        $data['netWorthJson'] = json_encode([
            'assets' => $assets,
            'liabilities' => $liabilities
        ]);

        $view = view('networth/main', $data);
        return $this->getPreparedView($view);
    }

    /**
     * Delete an asset by its ID
     */
    public function deleteAsset() {
        $userId = auth()->user()->id;
        $networthModel = $this->netWorthModel;

        $postData = $this->request->getPost();
        $payload = json_decode($postData['payload'], true);

        $result = $networthModel->deleteAssetById($userId, $payload['assetId']);

        $response = [
            'success' => $result,
            'message' => $result ? 'Asset deleted' : 'Failed to delete asset',
            'csrf' => csrf_hash(),
        ];

        return $this->response->setJSON($response); 
    }

    /**
     * Delete a liability by its ID
     */
    public function deleteLiability() {
        $userId = auth()->user()->id;
        $networthModel = $this->netWorthModel;

        $postData = $this->request->getPost();
        $payload = json_decode($postData['payload'], true);

        $result = $networthModel->deleteLiabilityById($userId, $payload['liabilityId']);

        $response = [
            'success' => $result,
            'message' => $result ? 'Liability deleted' : 'Failed to delete liability',
            'csrf' => csrf_hash(),
        ];

        return $this->response->setJSON($response); 
    }

    public function createOrUpdateAsset() {
        $userId = auth()->user()->id;
        $networthModel = $this->netWorthModel;

        $postData = $this->request->getPost();
        $payload = json_decode($postData['payload'], true);

        $response = [ 'csrf' => csrf_hash() ];

        if(isset($payload['create'])) {
            // Creating a new asset (false if failed, return id if succeeded)
            $response['assetId'] = $networthModel->createAsset($userId, $payload['name'], $payload['value'], $payload['category_id'], $payload['notes']);
            $response['success'] = (isset($response['assetId']) && $response['assetId'] && is_int($response['assetId']));
        } else {
            // Updating an existing asset
            $response['success'] = $networthModel->updateAsset($userId, $payload['asset_id'], $payload['name'], $payload['category_id'], $payload['notes'], $payload['value']);
        }

        $response['message'] = $response['success'] ? 'Asset updated' : 'Failed to update asset';
        return $this->response->setJSON($response); 
    }

    public function createOrUpdateLiability() {
        $userId = auth()->user()->id;
        $networthModel = $this->netWorthModel;

        $postData = $this->request->getPost();
        $payload = json_decode($postData['payload'], true);

        $response = [ 'csrf' => csrf_hash() ];

        log_message('info', 'Update liability called for: '.json_encode($payload));
        if(isset($payload['create'])) {
            // Creating a new asset (false if failed, return id if succeeded)
            $response['liabilityId'] = $networthModel->createLiability($userId, $payload['name'], $payload['value'], $payload['category_id'], $payload['notes']);
            $response['success'] = (isset($response['liabilityId']) && $response['liabilityId'] && is_int($response['liabilityId']));
        } else {
            // Updating an existing liability
            $response['success'] = $networthModel->updateLiability($userId, $payload['liability_id'], $payload['name'], $payload['category_id'], $payload['notes'], $payload['value']);
        }

        $response['message'] = $response['success'] ? 'Liability updated' : 'Failed to update liability';
        return $this->response->setJSON($response); 
    }
}
