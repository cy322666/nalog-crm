<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Shop\Shop;
use App\Models\Timezone;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shops = Shop::factory()
            ->count(10)
            ->state(new Sequence(fn ($sequence) => [
                'timezone_id' => Timezone::all()->random()->id,
                'currency_id' => Currency::all()->random()->id,
                ])
            )
            ->create();

        $roles = Role::query()
            ->where('shop_id', 0)
            ->where('name', '!=', 'root')
            ->get();

        foreach ($shops as $shop) {

            $shop->active = $shop->expired_at >= Carbon::now();
            $shop->save();

            foreach ($roles->toArray() as $role) {

                $role['is_system'] = false;
                $role['shop_id'] = $shop->id;

                unset($role['id']);

                $roleModel = Role::query()->create($role);

                if ($roleModel->name == 'Администратор') {

                    $permissions = Permission::all();
                }

                if ($roleModel->name == 'Менеджер') {

                    $permissions = Permission::query()
                        ->where('slug', 'like', "%view%")
                        ->orWhere('slug', 'like', "%create%")
                        ->orWhere('slug', 'like', "%update%")
                        ->get();
                }

                foreach ($permissions as $permission) {

                    $roleModel->permissions()->attach($permission->id);
                }
            }
        }
        $this->command->info('Шопы и связки прав и ролей созданы');
    }
}
