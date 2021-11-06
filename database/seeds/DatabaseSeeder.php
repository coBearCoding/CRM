<?php

use Illuminate\Database\Seeder;
use App\EstadoComercial;
use App\TipoEstudiante;
use App\Tipo;
use App\Acciones;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        /*$estados = [
            ['nombre'=>'Sin Gestionar','tipo'=>'L'],
            ['nombre'=>'No Interesado','tipo'=>'L'],
            ['nombre'=>'Seguimiento','tipo'=>'L'],
            ['nombre'=>'Inscrito','tipo'=>'L'],

            ['nombre'=>'Imposible Contactar','tipo'=>'S'],
            ['nombre'=>'Volver a Llamar','tipo'=>'S'],
            ['nombre'=>'No Contesta','tipo'=>'S'],
            ['nombre'=>'Proximo Año','tipo'=>'S'],
            ['nombre'=>'Correo Enviado','tipo'=>'S'],
            ['nombre'=>'Interesado','tipo'=>'S'],

            ['nombre'=>'Sin Gestionar','tipo'=>'C'],
            ['nombre'=>'No Interesado','tipo'=>'C'],
            ['nombre'=>'Seguimiento','tipo'=>'C'],
            ['nombre'=>'Inscrito','tipo'=>'C'],
            ['nombre'=>'Interesado','tipo'=>'C'],

        ];

        foreach($estados as $estado){
            EstadoComercial::create($estado);
        }

        $tipo = [
            ['nombre'=>'Regular'],
            ['nombre'=>'Convalidante'],
        ];

        foreach($tipo as $tip){
            TipoEstudiante::create($tip);
        }*/

        /*$tipos = [
            ['nombre'=>'Leads'],
            ['nombre'=>'Clientes'],
        ];

        foreach($tipos as $tip){
            Tipo::create($tip);
        }*/

        $acciones = [
            ['nombre'=>'CREACIÓN DE LEADS'],
            ['nombre'=>'MODIFICACIÓN DE LEADS'],
            ['nombre'=>'CAMBIO DE ESTADO COMERCIAL'],
            ['nombre'=>'ASIGNACIÓN DE VENDEDOR'],
            ['nombre'=>'CORREO ENVIADO'],
            ['nombre'=>'SEGUIMIENTO'],
            ['nombre'=>'TAREA'],
            ['nombre'=>'LLAMADA'],
            ['nombre'=>'CREACIÓN DE CLIENTE'],
            ['nombre'=>'MODIFICACIÓN DE CLIENTE'],
        ];

        foreach($acciones as $acc){
            Acciones::create($acc);
        }

    }
}
