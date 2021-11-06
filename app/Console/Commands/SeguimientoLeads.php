<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\SendNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\ContactoSeguimiento;

class SeguimientoLeads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seguimiento:leads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para el envio de notificaciones en laravel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            
            $query = "SELECT top 100 cs.id, cs.observacion , u.name as vendedor, u.email as correo_vendedor, cs.fecha_prox_contacto, c.nombre, c.telefono, c.correo from (
                            select id, contacto_tipo_id,fuente_contacto_id,estado_comercial_id, vendedor_id,campana_programa_id,created_at,observacion,
                            row_number() over(partition by contacto_tipo_id order by id desc) as rn
                            from contacto_historicos )
                            as T JOIN users u on T.vendedor_id = u.id
                            join contacto_seguimientos cs on T.contacto_tipo_id = cs.contacto_tipo_id
                            join tipo_contactos tc on T.contacto_tipo_id = tc.id
                            join contactos c on tc.contacto_id = c.id
                            where rn = 1
                            AND cs.fecha_prox_contacto between DATEADD(MINUTE , -15, getdate()) and DATEADD(MINUTE , 15, getdate()) and isnull(cs.notificado,'N') = 'N'";

            $datos = DB::select($query);    
            \Log::debug("---- ENTRO ----");
            foreach ($datos as $key => $info) {


                 if (!empty($info)) {
                       \Log::debug("---- NOTIFICA ----");
                       Mail::to($info->correo_vendedor)->send(new SendNotification($info));
                       //Mail::to('egordillo@links.com.ec')->send(new SendNotification($info));
                       $seguimiento = ContactoSeguimiento::find($info->id);
                       $seguimiento->notificado = 'S';
                       $seguimiento->save();
                    }
            }  

            DB::commit();
        


        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }
    }
}
