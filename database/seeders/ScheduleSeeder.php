<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['start' => '09:00', 'end' => '12:00', 'title' => 'Sabah Kuşağı', 'host' => 'DJ Ali'],
            ['start' => '12:00', 'end' => '15:00', 'title' => 'Öğle Yayını', 'host' => 'Desmal'],
            ['start' => '15:00', 'end' => '18:00', 'title' => 'Öğleden Sonra', 'host' => 'DJ Ayşe'],
            ['start' => '18:00', 'end' => '22:00', 'title' => 'Akşam Kuşağı', 'host' => 'Desmal'],
        ];

        foreach (range(0, 6) as $day) {
            $order = 0;
            foreach ($defaults as $d) {
                Schedule::create([
                    'day_of_week' => $day,
                    'start_time' => $d['start'],
                    'end_time' => $d['end'],
                    'title' => $d['title'],
                    'host' => $d['host'],
                    'is_active' => true,
                    'sort_order' => $order++,
                ]);
            }
        }
    }
}
