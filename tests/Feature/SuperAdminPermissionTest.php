<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ActivityLog;
use App\Services\ActivityLogger;
use Tests\TestCase;

class SuperAdminPermissionTest extends TestCase
{
    public function test_super_admin_has_unrestricted_permission(): void
    {
        $superAdmin = new User([
            'name' => 'Super User',
            'email' => 'super@test.com',
            'role' => 'super_admin',
            'permissions' => []
        ]);

        $this->assertTrue($superAdmin->isSuperAdmin());
        $this->assertTrue($superAdmin->hasPermission('berita'));
        $this->assertTrue($superAdmin->hasPermission('pmb'));
        $this->assertTrue($superAdmin->hasPermission('setting'));
    }

    public function test_admin_staff_only_has_assigned_permissions(): void
    {
        $staff = new User([
            'name' => 'Staff User',
            'email' => 'staff@test.com',
            'role' => 'admin',
            'permissions' => ['berita', 'pmb']
        ]);

        $this->assertFalse($staff->isSuperAdmin());
        $this->assertTrue($staff->hasPermission('berita'));
        $this->assertTrue($staff->hasPermission('pmb'));
        $this->assertFalse($staff->hasPermission('setting'));
        $this->assertFalse($staff->hasPermission('akreditasi'));
    }

    public function test_activity_logger_writes_entry(): void
    {
        $user = User::first();
        if ($user) {
            $initialCount = ActivityLog::count();
            ActivityLogger::log('CREATE', 'Unit Test', 'Testing logger service', $user);
            $this->assertEquals($initialCount + 1, ActivityLog::count());
        } else {
            $this->assertTrue(true);
        }
    }
}
