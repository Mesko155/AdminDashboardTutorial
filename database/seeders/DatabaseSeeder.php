<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Field;
use App\Models\Employee;
use App\Models\Practice;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Sole user as Administrator
        User::create([
            'name' => 'Meho',
            'email' => 'admin@mail.ba',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10)
        ]);
        
        // Factory seeding practice with multiple employes; randomised
        collect(range(1,40))
            ->each(function () {
                Practice::factory(1)
                ->has(Employee::factory(rand(1,10)))
                ->create();
            });
        
        // Manual tags for fields(fields of practice)
        Field::create(['tag' => 'Allergy and Immunology']);
        Field::create(['tag' => 'Anesthesiology']);
        Field::create(['tag' => 'Dermatology']);
        Field::create(['tag' => 'Diagnostic radiology']);
        Field::create(['tag' => 'Emergency medicine']);
        Field::create(['tag' => 'Family medicine']);
        Field::create(['tag' => 'Internal medicine']);
        Field::create(['tag' => 'Medical genetics']);

        // Randomised seeds for pivot table       
        $amountOfPractices = Practice::count();
        $amountOfFieldsOfPractice = Field::count();

        $x = range(1,$amountOfPractices);
        $array = [];
        $finalArray = [];

        foreach($x as $i) {
	        $array = [];

            foreach(range(1,rand(1,$amountOfFieldsOfPractice)) as $y) {
    	    $array[] = rand(1,$amountOfFieldsOfPractice);
            }

            $finalArray[] = array_unique($array);
        }

        $incrementer = 1;
        
        foreach($finalArray as $arrayToAdd) {
            foreach($arrayToAdd as $singleValue) {
                DB::table('field_practice')->insert([
                    'field_id' => $singleValue,
                    'practice_id' => $incrementer
                ]);
            }
            $incrementer = $incrementer + 1;
        }

        //attach, detach

        

    }
}
