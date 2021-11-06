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

class ReasignarLeadsGrado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reasignar:grado';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reasignación automatica de leads Grado';

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

            #QUERY PARA CONSULTAR LOS LEADS QUE TENGAS MAS DE 48 HORAS SIN GESTIONAR (ESTADO COMERCIAL 1)
            $oferta_academica_id = 1; #id de Grado tabla nivel primario
            $hours = 48; #id de posgrado tabla nivel primario
            $query = "SELECT --COUNT(1)
                 TOP 1000 T.*,(select campana_id from campana_programa where id = T.campana_programa_id) as campana_id
                ,(select cp.nsecundario_id from campana_programa where id = T.campana_programa_id) as nsecundario_id
                from (
                select id, contacto_tipo_id,fuente_contacto_id,estado_comercial_id, vendedor_id,campana_programa_id,created_at,observacion,reasignar,
                row_number() over(partition by contacto_tipo_id order by id desc) as rn
                from contacto_historicos )
                as T join tipo_contactos tc on T.contacto_tipo_id  = tc.id
                join campana_programa cp on T.campana_programa_id = cp.id
                join nivel_secundario ns on cp.nsecundario_id = ns.id
                join nivel_primario np on ns.nprimario_id = np.id
                where rn = 1 and tc.tipo_id = 1 and T.estado_comercial_id in (1,3)
                and np.id = '1' and isnull(T.reasignar,'N') = 'N'
                and T.created_at between '2021-01-01 00:00:00' and '2021-04-22 23:59:59'";

            $leads_singestionar = DB::select($query);    

            foreach ($leads_singestionar as $key => $leads) {
                $nombre_asesor = '';
                $telf_asesor = '';
                $email_asesor = '';

                $asesor = DB::selectOne("SELECT users.id,  users.name, (
                            select count(1) from (select id, contacto_tipo_id,fuente_contacto_id,estado_comercial_id, vendedor_id,campana_programa_id,created_at,observacion,reasignar,
                            row_number() over(partition by contacto_tipo_id order by id desc) as rn
                            from contacto_historicos) T where T.rn = 1    and T.created_at
                            between '2021-01-01 00:00:00' and '2021-04-22 23:59:59' and T.vendedor_id = users.id
                            and T.estado_comercial_id in (1,3)
                        ) as total
                    from campana_users
                    join users on campana_users.user_id = users.id
                    where campana_id = 17 and estado = 'A'
                    order by total asc");

                    if (!empty($asesor)) {
                       \Log::debug("id --> " .$leads->id);

                        $historico = ContactoHistorico::find($leads->id);
                        $historico->vendedor_id = (!empty($asesor)) ? $asesor->id : null;
                        $historico->reasignar = 'S';
                        $historico->save();

                        $nombre_asesor = $asesor->name ?? '';

                        AuditoriaContacto::auditoria($leads->contacto_tipo_id, 3, "Se reasigna nuevo asesor $nombre_asesor, solicitado por Priscila Mite");
                    }
            }  

            DB::commit();
        


        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }
    }
}
