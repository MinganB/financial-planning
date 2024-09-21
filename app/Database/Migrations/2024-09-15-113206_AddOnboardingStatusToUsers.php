<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOnboardingStatusToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'onboarding_completed' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'onboarding_completed');
    }
}
