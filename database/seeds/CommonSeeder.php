<?php


use App\Branch;
use App\Department;
use App\Division;
use App\Role;
use App\Room;
use App\Staff;
use App\StaffRole;
use App\Township;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                "division_name" => 'Yangon',
            ],
            [
                "division_name" => 'Mandalay',
            ],
        ];

        $townships = [
            [
                "township_name" => "Kamaryut",
                "division_id" => 1,
            ],
            [
                "township_name" => "SanChaung",
                "division_id" => 1,
            ],
        ];

        $branches = [
            [
                "branch_name" => "uabTower@ Times City",
                "branch_address" => "Kyun Taw Rd, Yangon 11041, Myanmar (Burma).",
                "township_id" => 1,
            ],
            [
                "branch_name" => "Hledan",
                "branch_address" => "No.(89), Hledan Road, Kamaryut Township, Yangon Division.",
                "township_id" => 1,
            ],
        ];

        $departments = [
            [
                "department_name" => "Unknown",
            ],
            [
                "department_name" => "Fintech And Digital",
            ],
            [
                "department_name" => "Card And Merchant",
            ],
            [
                "department_name" => "Transformation",
            ],
            [
                "department_name" => "Human Resource",
            ],
            [
                "department_name" => "Compliance",
            ],
            [
                "department_name" => "Finance",
            ],
            [
                "department_name" => "Consumer Loans",
            ],
            [
                "department_name" => "Bancassurance",
            ],
            [
                "department_name" => "Audit",
            ],
            [
                "department_name" => "Technology",
            ],
            [
                "department_name" => "Operation",
            ],
            [
                "department_name" => "Adminstration",
            ],
            [
                "department_name" => "CEO Office",
            ],
            [
                "department_name" => "Legal And Secretariat",
            ],
        ];

        $staffRoles = [
            [
                "name" => "Unknown",
            ],
            [
                "name" => "Senior Manager",
            ],
            [
                "name" => "Manager",
            ],
            [
                "name" => "Assistant Manager",
            ],
            [
                "name" => "Senior Executive",
            ],
        ];

        $staffs = [
            [
                "name" => "Nay Lin Aung",
                "department_id" => 2,
                "branch_id" => 1,
                "staff_role_id" => 2,
                "email" => "nay.nla@uab.com.mm",
                "phone" => "09250160095"
            ],
            [
                "name" => "Thant Zin That",
                "department_id" => 2,
                "branch_id" => 1,
                "staff_role_id" => 4,
                "email" => "thetzinthet@uab.com.mm",
                "phone" => "09782417621"
            ],
            [
                "name" => "Lwin Moe Paing",
                "department_id" => 2,
                "branch_id" => 1,
                "staff_role_id" => 4,
                "email" => "lwinmoepaing@uab.com.mm",
                "phone" => "09420059241"
            ],
        ];

        $users = [
            [
                "name" => "Developer",
                "email" => "developer@gmail.com",
                "password" => Hash::make("developer123"),
                "role_id" => 1,
            ],
            [
                "name" => "Mg Admin",
                "email" => "admin@gmail.com",
                "password" => Hash::make("admin123"),
                "role_id" => 2,
            ],
            [
                "name"  => "Mg Recipient",
                "email" => "recipient@gmail.com",
                "passowrd" => Hash::make("recipient123"),
                "role_id" => 3,
            ]

        ];

        $rooms = [
            [
                "room_name" => "Kayar",
                "seat_count" => 20,
                "area" => "10ft 20ft",
                "branch_id" => 1,
            ],
            [
                "room_name" => "Kachin",
                "seat_count" => 25,
                "branch_id" => 1,
                "area" => "",
            ],
            [
                "room_name" => "Chin",
                "seat_count" => 25,
                "branch_id" => 1,
                "area" => "",
            ],
        ];

        $roles = [
            ["name" => "SuperAdmin"],
            ["name" => "Admin"],
            ["name" => "Recipient"],
        ];

        $roles = $this->addDateAndID($roles);
        $divisions = $this->addDateAndID($divisions);
        $townships = $this->addDateAndID($townships);
        $branches = $this->addDateAndID($branches);
        $departments = $this->addDateAndID($departments);
        $rooms = $this->addDateAndID($rooms);
        $staffRoles = $this->addDateAndID($staffRoles);
        $staffs = $this->addDateAndID($staffs);
        $users = $this->addDateAndID($users);

        Division::insert($divisions);
        Township::insert($townships);
        Branch::insert($branches);
        Department::insert($departments);
        Room::insert($rooms);
        StaffRole::insert($staffRoles);
        Staff::insert($staffs);
        Role::insert($roles);
        User::insert($users);
    }

    public function addDateAndID($arr) {
        $id = 1;
        foreach ($arr as $key => $value) {
            $arr[$key]['id'] = $id;
            $arr[$key]['created_at'] = Carbon::now();
            $arr[$key]['updated_at'] = Carbon::now();
            $id++;
        }
        return $arr;
    }
}
