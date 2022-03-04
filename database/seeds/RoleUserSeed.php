<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Model\Role;

class RoleUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $roles = Role::all();
        foreach ($users as $user) { //tutti gli user
            $roleRandom = Role::inRandomOrder()->first()->id; //prendo un ruolo a caso 
            $user->roles()->attach($roleRandom); // lo inserisco

            foreach ($roles as $role) { //per ognuno dei ruoli
                $rand = random_int(0, 1); //genera un numero a caso
                if ((bool) $rand) { //se abbiamo true
                    if ($roleRandom !== $role->id) {
                        $user->roles()->attach($role->id); // inseriamo questo ruolo
                    }
                }
            }
        }

        // $roles = Role::all();
        // foreach ($roles as $role) {
        //     $idUser = User::inRandomOrder()->first()->id;
        //     $idUserTwo = User::inRandomOrder()->first()->id;

        //     while ($idUser == $idUserTwo) {
        //         $idUserTwo = User::inRandomOrder()->first()->id;
        //     }

        //     $role->users()->attach([$idUser, $idUserTwo]);
        // }
    }
}
