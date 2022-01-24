<?php

use App\Branch;
use App\Department;
use App\Division;
use App\Township;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CommonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Common Seeder All Cities List You had to added
        $divisions = [
            [
                "id" => 1,
                "division_name" => 'Yangon',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ]
        ];

        $townships = [
            [
                "id" => 1,
                "township_name" => "Kamaryut",
                "division_id" => 1,
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ]
        ];

        $branches = [
            [
                "id" => 1,
                "branch_name" => "uabTower@ Times City",
                "branch_address" => "Kyun Taw Rd, Yangon 11041, Myanmar (Burma).",
                "township_id" => 1,
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                "id" => 2,
                "branch_name" => "Hledan",
                "branch_address" => "No.(89), Hledan Road, Kamaryut Township, Yangon Division.",
                "township_id" => 1,
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
        ];

        $departments = [
            [
                "id" => 1,
                "department_name" => "Fintech And Digital",
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                "id" => 2,
                "department_name" => "Recipient",
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
        ];

        Division::insert($divisions);
        Township::insert($townships);
        Branch::insert($branches);
        Department::insert($departments);
    }
}
