<?php namespace App\Console\Commands;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateRoles extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create Role For users ';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Master account',
            'slug' => 'master',
        ]);
        $role->permissions = [
            'members.all' => true,
            'master' => true,
        ];
        $role->save();

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Finance',
            'slug' => 'finance',
        ]);
        $role->permissions = [
            'members.all' => true,
            'master' => true,
        ];
        $role->save();

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Administration',
            'slug' => 'administration',
        ]);
        $role->permissions = [
            'members.all' => true,
            'master' => true,
        ];
        $role->save();

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Staff',
            'slug' => 'staff',
        ]);
       $role->permissions = [
            'members.all' => true,
            'master' => true,
        ];
        $role->save();

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Driver',
            'slug' => 'driver',
        ]);
        $role->permissions = [
            'members.all' => true,
            'master' => true,
        ];
        $role->save();

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Company Agent',
            'slug' => 'company_agent',
        ]);
        $role->permissions = [
            'members.all' => true,
            'master' => true,
        ];
        $role->save();


        /* $user = Sentinel::findById(3);



         $role->users()->attach($user);*/
    }

}
