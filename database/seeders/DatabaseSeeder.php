<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'BeBee',
            'email' => 'bebeeneedevangeline@gmail.com',
            'gender' => 'male',
            'date' => '2002-12-23',
            'password' => Hash::make('bebee7121'),
            'image' => '649b135585b84photo_2023-06-27_16-49-27.jpg',
            'bio' => 'return 0;',
            'status' => 'In a relationship',
            'address' => 'Hinthada'
        ]);

        User::create([
            'name' => 'Thaw Bhone Han',
            'email' => 'trioz@gmail.com',
            'gender' => 'male',
            'date' => '2003-10-10',
            'password' => Hash::make('trioz369'),
            'image' => 'photo_2023-06-08_16-30-27.jpg',
            'bio' => "ThawTar smile is enough",
            'status' => 'In a relationship',
            'address' => 'Hinthada'
        ]);

        User::create([
            'name' => 'Kaoru Cho',
            'email' => 'kaoru@gmail.com',
            'gender' => 'female',
            'date' => '2003-9-15',
            'password' => Hash::make('kaoru7121'),
            'image' => 'photo_2023-06-08_14-44-16.jpg',
            'bio' => "If you can't find someone good,be the good one",
            'status' => 'In a relationship',
            'address' => 'Hinthada'
        ]);

        User::create([
            'name' => 'Zayyum Lin Latt',
            'email' => 'zayyumlinlatt@gmail.com',
            'gender' => 'male',
            'date' => '2002-4-29',
            'password' => Hash::make('zayyum69'),
            'image' => '269622526_1325214981259450_2557550057239454746_n.jpg',
            'status' => 'In a relationship',
            'address' => 'Hinthada'
        ]);

        User::create([
            'name' => 'Su Lay Maung',
            'email' => 'sulaymaung@gmail.com',
            'gender' => 'female',
            'date' => '2005-4-29',
            'password' => Hash::make('susu123'),
            'image' => '353466763_273005778582458_6496524745253853790_n.jpg',
            'status' => 'In a relationship',
            'address' => 'Mandalay'
        ]);

        User::create([
            'name' => 'Min Thway Htet',
            'email' => 'minthwayhtet@gmail.com',
            'gender' => 'male',
            'date' => '2001-2-13',
            'password' => Hash::make('tokegyi69'),
            'image' => 'photo_2023-07-06_12-24-04.jpg',
            'bio' => "Do more work and talk less",
            'status' => 'In a relationship',
            'address' => 'Hinthada'
        ]);

        User::create([
            'name' => 'Myat Akari Moe',
            'email' => 'myatakarimoe@gmail.com',
            'gender' => 'female',
            'date' => '2002-2-13',
            'password' => Hash::make('babe223'),
            'image' => '193108797_538930020614470_3118592516031567024_n.jpg',
            'status' => 'Single',
            'address' => 'Hinthada'
        ]);

    }
}
