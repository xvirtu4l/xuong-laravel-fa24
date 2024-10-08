<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{   
    public $model = Employee::class;
    /**
     * Define the model's default state.
     *  
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'    =>fake()->firstName,
            'last_name'     =>fake()->lastName,
            'email'         =>fake()->unique()->email(),
            'phone'         =>fake()->phoneNumber(),
            'date_of_birth' =>fake()->date,
            'hire_date'     =>fake()->dateTime,
            'salary'        =>fake()->randomFloat(4,50000,100000) ,
            'is_active'     =>rand(0, 1),
            'department_id' =>rand(1, 2),
            'manager_id'    =>rand(1, 2),
            'address'       =>fake()->address,
            'created_at'    =>now(),
            'updated_at'    =>now()
        ];
    }
}
