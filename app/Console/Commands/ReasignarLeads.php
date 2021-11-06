<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\CrmEvents;
use Illuminate\Support\Facades\DB;
use App\Contacto;
use App\User;
use App\TipoContacto;
use App\ContactoHistorico;
use App\AuditoriaContacto;


class ReasignarLeads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reasignar:leads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reasignación automatica de leads despues de las 48h sin gestión Postgrado';

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
            \Log::debug("---- AQUI ----");
            #QUERY PARA CONSULTAR LOS LEADS QUE TENGAS MAS DE 48 HORAS SIN GESTIONAR (ESTADO COMERCIAL 1)
            $posgrado_id = 2; #id de posgrado tabla nivel primario
            $hours = 48; #id de posgrado tabla nivel primario
            $query = "SELECT T.*,(select campana_id from campana_programa where id = T.campana_programa_id) as campana_id
                        ,(select cp.nsecundario_id from campana_programa where id = T.campana_programa_id) as nsecundario_id from (
                        select id, contacto_tipo_id,fuente_contacto_id,estado_comercial_id, reasignar,vendedor_id,campana_programa_id,created_at,observacion,
                        row_number() over(partition by contacto_tipo_id order by id desc) as rn
                        from contacto_historicos )
                        as T join tipo_contactos tc on T.contacto_tipo_id  = tc.id
                        join campana_programa cp on T.campana_programa_id = cp.id
                        join nivel_secundario ns on cp.nsecundario_id = ns.id
                        join nivel_primario np on ns.nprimario_id = np.id
                        where rn = 1 and tc.tipo_id = 1 and T.estado_comercial_id = 1 and np.id = '".$posgrado_id."' 
                        AND DATEADD(HOUR, $hours, T.created_at) <= GETDATE() and isnull(T.reasignar,'N') = 'N'";

            $leads_singestionar = DB::select($query);    

            foreach ($leads_singestionar as $key => $leads) {
                $nombre_asesor = '';
                $telf_asesor = '';
                $email_asesor = '';

                $asesor = DB::selectOne('SELECT cu.user_id, count(distinct ch.contacto_tipo_id) leads , u.id, u.name, u.email, u.status, p.celular as telefono
                                    FROM campana_users cu
                                           left join contacto_historicos ch on ch.vendedor_id = cu.user_id
                                           join campana c on  c.id = cu.campana_id and c.id = :campana
                                           join users u on u.id = cu.user_id
                                           join profiles p on p.user_id = u.id
                                           left join estado_comercial ec on ec.id= ch.estado_comercial_id and ch.estado_comercial_id in (SELECT id FROM estado_comercial where id not in (2,5,7,8))
                                    where c.estado = :estado and cu.estado=:estado_a and cu.user_id <> :user_id 
                                    group by cu.user_id,  u.id, u.name, u.email, u.status, p.celular
                                    order by count(distinct ch.contacto_tipo_id)', ['campana' => $leads->campana_id, 'estado' => 'A', 'estado_a' => 'A','user_id'=>$leads->vendedor_id]);

                    if (!empty($asesor)) {
                       \Log::debug("---- AQUI ----");
                        /*$historico = new ContactoHistorico;
                        $historico->contacto_tipo_id = $leads->contacto_tipo_id;
                        $historico->fuente_contacto_id = $leads->fuente_contacto_id;
                        $historico->campana_programa_id = $leads->campana_programa_id;
                        $historico->estado_comercial_id = 1;
                        $historico->created_by = 34;
                        $historico->observacion = 'Se reasigna un nuevo asesor';
                        $historico->vendedor_id = (!empty($asesor)) ? $asesor->id : null;
                        $historico->nsecundario_id = $leads->nsecundario_id;
                        $historico->campana_id = $leads->campana_id;
                        $historico->save();*/

                        $historico = ContactoHistorico::find($leads->id);
                        $historico->vendedor_id = (!empty($asesor)) ? $asesor->id : null;
                        $historico->reasignar = 'S';
                        $historico->save();

                        $nombre_asesor = $asesor->name ?? '';
                        $telf_asesor = $asesor->telefono ?? '';
                        $email_asesor = $asesor->email ?? '';

                        AuditoriaContacto::auditoria($leads->contacto_tipo_id, 3, "Se reasigna Asesor $nombre_asesor, solicitado por Andrea Rosales");
                        $datos = TipoContacto::with('contacto')->with('contacto_historico_last')->find($leads->contacto_tipo_id);
                        #if (!empty($datos)) {
                            #event(new CrmEvents($datos)); #se guarda en la tabla notificaciones y se envia en mail al asesor
                        #}
                    }
            }  

            DB::commit();
        


        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }


    }
}
