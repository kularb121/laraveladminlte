<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'email')) {
                $table->index('email');
            }
        });

        Schema::table('devices', function (Blueprint $table) {
            if (!Schema::hasColumn('devices', 'number')) {
                $table->index('number');
            }
            if (!Schema::hasColumn('devices', 'status_id')) {
                $table->index('status_id');
            }
            if (!Schema::hasColumn('devices', 'customer_id')) {
                $table->index('customer_id');
            }
        });

        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'number')) {
                $table->index('number');
            }
            if (!Schema::hasColumn('assets', 'status_id')) {
                $table->index('status_id');
            }
        });

        Schema::table('sites', function (Blueprint $table) {
            if (!Schema::hasColumn('sites', 'name')) {
                $table->index('name');
            }

        });

        Schema::table('device_assets', function (Blueprint $table) {
            if (!Schema::hasColumn('device_assets', 'device_id')) {
                $table->index('device_id');
            }
            if (!Schema::hasColumn('device_assets', 'asset_id')) {
                $table->index('asset_id');
            }
            if (!Schema::hasColumn('device_assets', 'status_id')) {
                $table->index('status_id');
            }
        });

        Schema::table('asset_sites', function (Blueprint $table) {
            if (!Schema::hasColumn('asset_sites', 'asset_id')) {
                $table->index('asset_id');
            }
            if (!Schema::hasColumn('asset_sites', 'site_id')) {
                $table->index('site_id');
            }
            if (!Schema::hasColumn('asset_sites', 'status_id')) {
                $table->index('status_id');
            }
        });

        Schema::table('statuses', function (Blueprint $table) {
            if (!Schema::hasColumn('statuses', 'name')) {
                $table->index('name');
            }
        });

        Schema::table('iot_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('iot_applications', 'device_id')) {
                $table->index('device_id');
            }
            if (!Schema::hasColumn('iot_applications', 'asset_id')) {
                $table->index('asset_id');
            }
            if (!Schema::hasColumn('iot_applications', 'status')) {
                $table->index('status');
            }
        });

        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'name')) {
                $table->index('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->dropIndex(['number']);
            $table->dropIndex(['status_id']);
            $table->dropIndex(['customer_id']);
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->dropIndex(['number']);
            $table->dropIndex(['status_id']);
            $table->dropIndex(['customer_id']);
        });

        Schema::table('sites', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['status_id']);
        });

        Schema::table('device_assets', function (Blueprint $table) {
            $table->dropIndex(['device_id']);
            $table->dropIndex(['asset_id']);
            $table->dropIndex(['status_id']);
        });

        Schema::table('asset_sites', function (Blueprint $table) {
            $table->dropIndex(['asset_id']);
            $table->dropIndex(['site_id']);
            $table->dropIndex(['status_id']);
        });

        Schema::table('statuses', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });

        Schema::table('iotapplications', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['status_id']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });
    }
};