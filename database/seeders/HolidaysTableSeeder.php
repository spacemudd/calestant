<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('holidays')->insert([
            ['date' => '2025-01-01', 'reason' => 'New Year\'s Day'],
            ['date' => '2025-03-20', 'reason' => 'Founding Day'],
            ['date' => '2025-03-31', 'reason' => 'Eid al-Fitr Holiday Start'],
            ['date' => '2025-04-01', 'reason' => 'Eid al-Fitr'],
            ['date' => '2025-04-02', 'reason' => 'Eid al-Fitr'],
            ['date' => '2025-04-03', 'reason' => 'Eid al-Fitr'],
            ['date' => '2025-04-04', 'reason' => 'Eid al-Fitr Holiday End'],
            ['date' => '2025-06-05', 'reason' => 'Eid al-Adha Holiday Start'],
            ['date' => '2025-06-06', 'reason' => 'Eid al-Adha'],
            ['date' => '2025-06-07', 'reason' => 'Eid al-Adha'],
            ['date' => '2025-06-08', 'reason' => 'Eid al-Adha Holiday End'],
            ['date' => '2025-09-23', 'reason' => 'Saudi National Day'],
        ]);
    }
}
