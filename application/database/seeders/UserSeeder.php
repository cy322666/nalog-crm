<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Shop\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Throwable;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::query()
            ->where('email', 'cy322666@gmail.com')
            ->first()) {

            $root = User::factory()->create([
                'name'  => 'root',
                'email' => 'cy322666@gmail.com',
            ]);

            $root->roles()->attach(Role::query()->first()->id);
        }

        $users = User::factory(30)->create();

        foreach ($users as $user) {

            for ($i = 0; $i < 3; $i++) {

                if (rand(1,0) == 1 || $i == 0) {

                    $shop = Shop::all()->random();

                    $user->shops()->attach($shop->id);

                    $role = $shop->roles->random();

                    try {

                        $user->roles()->attach($role->id);

                    } catch (Throwable $exception) {

                        print_r($exception->getMessage());
                    }

                    foreach ($role->permissions as $permission) {

                        try {

                            $user->permissions()->attach($permission->id, ['shop_id' => $shop->id]);

                        } catch (Throwable $exception) {

                            print_r($exception->getMessage());
                        }
                    }
                }
            }
        }
        $this->command->info('Рут и юзеры + связка с шопами + права юзеров созданы');
    }
}
