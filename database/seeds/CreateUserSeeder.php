<?php
use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
$user = User::create([
'name'     => 'Ziad Bawaknh',
'email'    => 'admin@gmail.com',
'password' => bcrypt('123456789'),
'roles_name'=>["Admin"],
'status'   =>'مفعل',
]);

$role = Role::create(['name' => 'Admin']);

$permissions = Permission::pluck('id','id')->all();

$role->syncPermissions($permissions);

$user->assignRole([$role->id]);
}
}