<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
        if(class_exists(\Tall\Form\Models\Status::class)){
        \Tall\Form\Models\Status::factory()->create([
            'name'=>'Published'
        ]);
        \Tall\Form\Models\Status::factory()->create([
            'name'=>'Draft'
        ]);
        }
        if(class_exists(\Tall\Tenant\Models\Tenant::class)){
        $host = \Str::replace("www.",'',request()->getHost());
        \Tall\Tenant\Models\Tenant::factory()->create([
            'name'=> 'Base',
            'domain'=> $host,
            'database'=>env("DB_DATABASE","landlord"),
            'prefix'=>'landlord',
            'middleware'=>'landlord',
            'provider'=>'mysql',
        ]);
        }
        \App\Models\User::query()->forceDelete();        
        \App\Models\User::factory(100)->create();
        $user =   \App\Models\User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        ]);

        \Tall\Acl\Models\Role::query()->forceDelete();
        $role =  \Tall\Acl\Models\Role::factory()->create([
            'name' => 'Super Admin',
            'slug' => 'super-admin',
            'special'=>'all-access'
        ]);
        $user->roles()->sync([$role->id->toString()]);
        
    }
}
