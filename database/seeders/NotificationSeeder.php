<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_notifications.json');
        $json = json_decode($json_file , true);
        foreach ($json['data'] as $row) {
            Notification::query()->create([
                "content" => $row['content'],
                "user_id" => $row['user_id'],
                "from_id" => $row['from_id'],
                "create_at" => $row['create_at'],
                "read_at" => $row['read_at'],
                "note" => $row['note'],
           ]);
        }
    }
}
