<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('rsg_users')->insert([
            'email' => 'gerson.quezada@manuela.org.pe',
            'password' => Hash::make('123456'),
            'VC_CELULAR' => '968077817',
            'BT_ESTADO_FILA' => '1',
            'VC_USUARIO_CREACION' => 'SYSTEM',
            'VC_USUARIO_MODIFICACION' => '',
            'BT_ACT_PASSWORD_OBLIGATORIO' => '0',
            'created_at' => new \DateTime(),
        ]);


        $SucursalAdmin = [
            ['IN_USUARIO_ID' => '1',
            'VC_COD_SUCURSAL' => '002',
            'VC_DES_SUCURSAL' => 'UCAYALI',
            'BT_ESTADO_FILA' => '1',
            'VC_USUARIO_CREACION' => 'SYSTEM',
            'created_at' => new \DateTime(),],
            ['IN_USUARIO_ID' => '1',
            'VC_COD_SUCURSAL' => '003',
            'VC_DES_SUCURSAL' => 'SAN MARTIN',
            'BT_ESTADO_FILA' => '1',
            'VC_USUARIO_CREACION' => 'SYSTEM',
            'created_at' => new \DateTime(),],
            ['IN_USUARIO_ID' => '1',
            'VC_COD_SUCURSAL' => '004',
            'VC_DES_SUCURSAL' => 'PUNO',
            'BT_ESTADO_FILA' => '1',
            'VC_USUARIO_CREACION' => 'SYSTEM',
            'created_at' => new \DateTime(),],
            ['IN_USUARIO_ID' => '1',
            'VC_COD_SUCURSAL' => '005',
            'VC_DES_SUCURSAL' => 'LA LIBERTAD',
            'BT_ESTADO_FILA' => '1',
            'VC_USUARIO_CREACION' => 'SYSTEM',
            'created_at' => new \DateTime(),],
            ['IN_USUARIO_ID' => '1',
            'VC_COD_SUCURSAL' => '011',
            'VC_DES_SUCURSAL' => 'LAMBAYEQUE',
            'BT_ESTADO_FILA' => '1',
            'VC_USUARIO_CREACION' => 'SYSTEM',
            'created_at' => new \DateTime(),],
            ['IN_USUARIO_ID' => '1',
            'VC_COD_SUCURSAL' => '007',
            'VC_DES_SUCURSAL' => 'AMAZONAS',
            'BT_ESTADO_FILA' => '1',
            'VC_USUARIO_CREACION' => 'SYSTEM',
            'created_at' => new \DateTime(),]
        ];

        foreach ($SucursalAdmin as $key){
            DB::table('rsg_usuario_sucursal')->insert([
                'IN_USUARIO_ID' => $key['IN_USUARIO_ID'],
                'VC_COD_SUCURSAL' => $key['VC_COD_SUCURSAL'],
                'VC_DES_SUCURSAL' => $key['VC_DES_SUCURSAL'],
                'BT_ESTADO_FILA' => $key['BT_ESTADO_FILA'],
                'VC_USUARIO_CREACION' => $key['VC_USUARIO_CREACION'],
                'created_at' => $key['created_at'],
            ]);
        }


    }
}
