<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\RequestTemplates\RequestTemplate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $this->call([
            UserSeeder::class,
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            ManagerDepartmentsSeeder::class,
            RequestTemplateSeeder::class,
            RequestTemplateStepSeeder::class,
            OrderStepsSeeder::class,
            RequestTypeSeeder::class,
            SlutSeeder::class,
            RequestSeeder::class,
            RequiredSeeder::class,
            CollageinformationSeeder::class,
            // RequestListSeeder::class,
            // DataSeeder::class,
            // RequestLogSeeder::class,
            NotificationSeeder::class,
            PermissionsSeeder::class

        ]);
    }
}
