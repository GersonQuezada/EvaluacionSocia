<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        $roles = [
            ['VC_DESCRIPCION'=> 'Administrador', 'BT_ESTADO_FILA' => '1', 'VC_USUARIO_CREACION' => 'SYSTEM', 'DT_FECHA_CREACION' => new \DateTime()],
            ['VC_DESCRIPCION'=> 'Supervisora', 'BT_ESTADO_FILA' => '1', 'VC_USUARIO_CREACION' => 'SYSTEM', 'DT_FECHA_CREACION' => new \DateTime()],
            ['VC_DESCRIPCION'=> 'Oficial de Credito', 'BT_ESTADO_FILA' => '1', 'VC_USUARIO_CREACION' => 'SYSTEM', 'DT_FECHA_CREACION' => new \DateTime()],
        ];

        foreach ($roles as $rol) {
            DB::table('RSG_ROLES')->insert([
                'VC_DESCRIPCION' => $rol['VC_DESCRIPCION'],
                'BT_ESTADO_FILA' => $rol['BT_ESTADO_FILA'],
                'VC_USUARIO_CREACION' => $rol['VC_USUARIO_CREACION'],
                'created_at' => $rol['DT_FECHA_CREACION']
            ]);
        }

        // DB::table('rsg_roles_usuario')->insert([
        //     'IN_USUARIO_ID' => '1',
        //     'IN_ROL_ID' => '1',
        //     'BT_ESTADO_FILA' => '1',
        //     'VC_USUARIO_CREACION' => 'SYSTEM',
        //     'created_at' =>  new \DateTime()
        // ]);

    }
}
