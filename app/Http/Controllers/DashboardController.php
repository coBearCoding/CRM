<?php

namespace App\Http\Controllers;

use App\Periodo;
use App\FuentesContacto;
use App\PermisosNPrimario;
use App\TipoContacto;
use App\Campana;
use App\EstadoComercial;
use App\NivelPrimario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    protected $objinfoUser;
    protected $permiso_np;

    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('guest')->except('logout');
        $this->middleware(function ($request, $next) {
            $this->objinfoUser = Session::get('infoUser');
            $this->permiso_np = Session::get('permiso_np');
            return $next($request);
        });
    }

    public function logout(Request $request)
    {

        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        echo Artisan::call('config:clear');
        echo Artisan::call('config:cache');
        echo Artisan::call('cache:clear');
        echo Artisan::call('route:clear');
        $request->session()->flush();
        Session::flush();
        Session::forget('login');
        Session::put('login', 'no');
        Session::save();
        // Auth::guard($this->getGuard())->logout();
        $request->session()->regenerate(true);
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time() - 1000);
                setcookie($name, '', time() - 1000, '/');
            }
        }

        // Session::flush();
        //   return redirect('/');

        // Session::put('logout','desactivar');
        //Auth::logout();
        return view('auth.login');
        // return redirect()->route('viewListaCampania');

    }

    public function index()
    {
        $periodo = session('periodo');
        #comentado por que carga en detalle desde un llamado en javascript
        //$rowLeas = DB::select('exec sp_tipo_contacto_dashboard ?,?,?,?,?,?', [$periodo, 0, 0, 0, 1,$this->objinfoUser->user_id]);
        //$rowClie = DB::select('exec sp_tipo_contacto_dashboard ?,?,?,?,?,?', [$periodo, 0, 0, 0, 2,$this->objinfoUser->user_id]);

        $totalLeads = $rowLeas[0]->total ?? 0;
        $totalClientes = $rowClie[0]->total ?? 0;

        $totalCampana = Campana::where('estado', 'A')->count();
        $lstPeriodo = Periodo::where('estado', 'A')->orderBy('anio', 'desc')->get();
        $EstadoComercials = EstadoComercial::where('tipo', 'L')->get();
        $lstCampana = Campana::where('estado', 'A')->where('periodo_id', session('periodo'))->get();
        $ofertaCadamicas = PermisosNPrimario::where('permisos_nprimario.user_id', $this->objinfoUser->user_id)->
        join('nivel_primario', 'nivel_primario.id', 'permisos_nprimario.nprimario_id')
            ->where('nivel_primario.estado', 'A')->get();
        $totalFteContacto = FuentesContacto::where('estado', 'A')->count();

        return view('home', compact('lstPeriodo',  'totalFteContacto', 'totalLeads', 'lstCampana', 'totalClientes', 'totalCampana', 'ofertaCadamicas', 'EstadoComercials'));
    }


    public function detalle(Request $request)
    {
        Session::put('periodo', $request->periodo);
        Session::put('campana', $request->campana);
        Session::put('sede', $request->sede);
        Session::put('d_nivel1', $request->nprimario);

        $permiso_np = isset($this->permiso_np) ? implode(',',$this->permiso_np) : 0;
        $periodo = session('periodo');
        $campana = session('campana');
        $sede = session('sede');
        $nivel1 = session('d_nivel1');

        $sql_leads = "SELECT count(*) as total
        FROM tipo_contactos tc
                 join (select id, contacto_tipo_id,campana_programa_id,created_at,
             estado_comercial_id, isnull(fuente_contacto_id,13) as fuente_contacto_id,
             row_number() over(partition by contacto_tipo_id order by id desc) as rn
             from contacto_historicos) chs on chs.contacto_tipo_id = tc.id
                 JOIN campana_programa cp on chs.campana_programa_id = cp.id
                 JOIN campana c on cp.campana_id = c.id
              join contactos co on tc.contacto_id = co.id
        WHERE ($campana = 0 OR ($campana <> 0 AND cp.campana_id = $campana))
          AND ($sede = 0 OR ($sede <> 0 AND (c.sede_id = $sede or c.sede_id IS NULL)))
        AND tc.tipo_id=? and rn = 1 and co.estado ='A' ";
        if($periodo > 0 ){
            $sql_leads .= " AND YEAR(chs.created_at) = (select anio from periodos where id = $periodo) ";
        }
        if($nivel1 > 0 ){
            $sql_leads .= " AND cp.nsecundario_id in
            (select ns.id
            from nivel_secundario ns
            join nivel_primario np on ns.nprimario_id = np.id and np.id = $nivel1) ";
        }else{
            $sql_leads .= " AND cp.nsecundario_id in (select id from nivel_secundario where nprimario_id in ($permiso_np)) ";
        }
        $rowLeas = DB::select($sql_leads,[1]);
        $rowClie = DB::select($sql_leads,[2]);
        //return $sql_leads;

        $totalLeads = $rowLeas[0]->total;
        $totalClientes = $rowClie[0]->total;

        if ($request->sede == 0) {
            if($periodo > 0 ){
                $totalCampana = Campana::where('estado', 'A')->where('periodo_id', session('periodo'))->orWhereNull('periodo_id')->count();
                $lstCampana = Campana::where('estado', 'A')->where('periodo_id', session('periodo'))->orWhereNull('periodo_id')->get();
            }else{
                $totalCampana = Campana::where('estado', 'A')->count();
                $lstCampana = Campana::where('estado', 'A')->get();
            }
            
        } else {
            if($periodo > 0 ){
                $totalCampana = Campana::where('estado', 'A')->where('sede_id', $request->sede)->orWhereNull('sede_id')->where('periodo_id', session('periodo'))->orWhereNull('periodo_id')->count();
                $lstCampana = Campana::where('estado', 'A')->where('sede_id', $request->sede)->orWhereNull('sede_id')->where('periodo_id', session('periodo'))->orWhereNull('periodo_id')->get();
            }else{
                $totalCampana = Campana::where('estado', 'A')->where('sede_id', $request->sede)->orWhereNull('sede_id')->count();
                $lstCampana = Campana::where('estado', 'A')->where('sede_id', $request->sede)->orWhereNull('sede_id')->get();
            }

        }

        $EstadoComercials = EstadoComercial::where('tipo', 'L')->get();

        $ofertaCadamicas = PermisosNPrimario::where('permisos_nprimario.user_id', $this->objinfoUser->user_id)->
        join('nivel_primario', 'nivel_primario.id', 'permisos_nprimario.nprimario_id')
            ->where('nivel_primario.estado', 'A')->get();

        $totalFteContacto = FuentesContacto::where('estado', 'A')->count();
        return view('home_detail', compact( 'totalFteContacto', 'totalLeads', 'lstCampana', 'totalClientes', 'totalCampana', 'ofertaCadamicas', 'EstadoComercials'));
    }

    public function fuente_contacto(Request $request)
    {
        $periodo = session('periodo');
        $campana = session('campana');
        $sede = session('sede');
        $nivel1 = session('d_nivel1');
        $permiso_np = isset($this->permiso_np) ? implode(',',$this->permiso_np) : 0;
        $sql = "SELECT fc.id,
                fc.nombre,
                sum(isnull(fuente.ene, 0)) as ene,
                sum(isnull(fuente.feb, 0)) as feb,
                sum(isnull(fuente.mar, 0)) as mar,
                sum(isnull(fuente.abr, 0)) as abr,
                sum(isnull(fuente.may, 0)) as may,
                sum(isnull(fuente.jun, 0)) as jun,
                sum(isnull(fuente.jul, 0)) as jul,
                sum(isnull(fuente.ago, 0)) as ago,
                sum(isnull(fuente.sep, 0)) as sep,
                sum(isnull(fuente.oct, 0)) as oct,
                sum(isnull(fuente.nov, 0)) as nov,
                sum(isnull(fuente.dic, 0)) as dic
        FROM fuente_contacto fc
                join (
            SELECT isnull(chs.fuente_contacto_id, 13)                                            as id,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 1 then 1 else 0 end)  as ene,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 2 then 1 else 0 end)  as feb,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 3 then 1 else 0 end)  as mar,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 4 then 1 else 0 end)  as abr,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 5 then 1 else 0 end)  as may,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 6 then 1 else 0 end)  as jun,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 7 then 1 else 0 end)  as jul,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 8 then 1 else 0 end)  as ago,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 9 then 1 else 0 end)  as sep,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 10 then 1 else 0 end) as oct,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 11 then 1 else 0 end) as nov,
                    (case when CONVERT(VARCHAR(2), MONTH(chs.created_at)) = 12 then 1 else 0 end) as dic
            FROM contacto_historicos chs
            JOIN campana_programa cp on chs.campana_programa_id = cp.id
            JOIN campana c on cp.campana_id = c.id
            JOIN tipo_contactos tc on chs.contacto_tipo_id = tc.id and tc.tipo_id=?
            WHERE  ($campana = 0 OR ($campana <> 0 AND cp.campana_id = $campana))
            AND ($sede = 0 OR ($sede <> 0 AND (c.sede_id = $sede or c.sede_id IS NULL))) ";
            if($periodo > 0 ){
                $sql .= " AND YEAR(chs.created_at) = (select anio from periodos where id=$periodo) ";
            }
            if($nivel1 > 0 ){
                $sql .= " AND cp.nsecundario_id in
                (select ns.id
                from nivel_secundario ns
                join nivel_primario np on ns.nprimario_id = np.id and np.id = $nivel1) ";
            }else{
                $sql .= " AND cp.nsecundario_id in (select id from nivel_secundario where nprimario_id in ($permiso_np)) ";
            }
            $sql .= ") as fuente on fc.id = fuente.id group by fc.id, fc.nombre ";
            //return $sql;
        return DB::select($sql, [$request->tipo]);
    }


    public function oferta_academica(Request $request)
    {
        /*return DB::select('SELECT np.nombre, count(np.nombre) as total from contacto_historicos ch join campana_programa cp on ch.campana_programa_id = cp.id join nivel_secundario ns on cp.nsecundario_id = ns.id join nivel_primario np on ns.nprimario_id = np.id group by np.nombre');*/
        
        $nivel1 = session('d_nivel1');
        $permiso_np = isset($this->permiso_np) ? implode(',',$this->permiso_np) : 0;

        $sql = "SELECT  np.nombre, count(np.nombre) as total  from (
            select id, contacto_tipo_id,created_at,
            estado_comercial_id, vendedor_id,campana_programa_id,
            row_number() over(partition by contacto_tipo_id order by id desc) as rn
            from contacto_historicos
            ) as T join tipo_contactos tc on T.contacto_tipo_id  = tc.id
            join campana_programa cp on T.campana_programa_id = cp.id
            join nivel_secundario ns on cp.nsecundario_id = ns.id
            join nivel_primario np on ns.nprimario_id = np.id
            join contactos co on tc.contacto_id = co.id
            where rn = 1 and co.estado ='A' and tc.tipo_id = 1 ";
        if($request->periodo > 0 ){
            $sql .= " AND YEAR(T.created_at) = (select anio from periodos where id = '".$request->periodo."') ";
        }
        if($nivel1 > 0 ){
            $sql .= " AND cp.nsecundario_id in
            (select ns.id
            from nivel_secundario ns
            join nivel_primario np on ns.nprimario_id = np.id and np.id = $nivel1) group by np.nombre";
        }else{
            $sql .= " AND cp.nsecundario_id in (select id from nivel_secundario where nprimario_id in ($permiso_np)) group by np.nombre";
        }
        return DB::select($sql);
    }

    public function oferta_academica_mes(Request $request)
    {
        /*return DB::select('SELECT np.nombre, count(np.nombre) as total from contacto_historicos ch join campana_programa  cp on ch.campana_programa_id = cp.id join nivel_secundario ns on cp.nsecundario_id = ns.id join
            nivel_primario np on ns.nprimario_id = np.id where MONTH(ch.created_at) = MONTH(getdate()) group by np.nombre ');*/

        $nivel1 = session('d_nivel1');
        $permiso_np = isset($this->permiso_np) ? implode(',',$this->permiso_np) : 0;    

        $sql = "SELECT  np.nombre, count(np.nombre) as total  from (
            select id, contacto_tipo_id,
            estado_comercial_id, vendedor_id,campana_programa_id,created_at,
            row_number() over(partition by contacto_tipo_id order by id desc) as rn
            from contacto_historicos
            ) as T join tipo_contactos tc on T.contacto_tipo_id  = tc.id
            join campana_programa cp on T.campana_programa_id = cp.id
            join nivel_secundario ns on cp.nsecundario_id = ns.id
            join nivel_primario np on ns.nprimario_id = np.id
            join contactos co on tc.contacto_id = co.id
            where rn = 1 and co.estado ='A' and tc.tipo_id = 1 AND MONTH(T.created_at) = MONTH(getdate()) ";
            if($request->periodo > 0 ){
                $sql .= " AND YEAR(T.created_at) = (select anio from periodos where id = '".$request->periodo."')  ";
            }
            if($nivel1 > 0 ){
                $sql .= " AND cp.nsecundario_id in
                (select ns.id
                from nivel_secundario ns
                join nivel_primario np on ns.nprimario_id = np.id and np.id = $nivel1) group by np.nombre";
            }else{
                $sql .= " AND cp.nsecundario_id in (select id from nivel_secundario where nprimario_id in ($permiso_np)) group by np.nombre";
            }
            return DB::select($sql);
    }

    public function estado_comercial(Request $request)
    {
        # return DB::select('SELECT ec.nombre, count(ec.nombre) as total from contacto_historicos ch join estado_comercial ec on ch.estado_comercial_id = ec.id group by ec.nombre');
        
        $nivel1 = session('d_nivel1');
        $permiso_np = isset($this->permiso_np) ? implode(',',$this->permiso_np) : 0; 

        $sql = "SELECT ec.nombre, count(ec.nombre) as total from (
            select id, contacto_tipo_id,
            estado_comercial_id, vendedor_id,campana_programa_id,created_at,
            row_number() over(partition by contacto_tipo_id order by id desc) as rn
            from contacto_historicos
            ) as T join tipo_contactos tc on T.contacto_tipo_id  = tc.id
            join estado_comercial ec on T.estado_comercial_id = ec.id
            join campana_programa cp on T.campana_programa_id = cp.id
            join nivel_secundario ns on cp.nsecundario_id = ns.id
            join nivel_primario np on ns.nprimario_id = np.id
            join contactos co on tc.contacto_id = co.id
            where rn = 1 and co.estado ='A' and tc.tipo_id = 1 " ;
        if($request->periodo > 0 ){
            $sql .= " AND YEAR(T.created_at) = (select anio from periodos where id = '".$request->periodo."') ";
        }
        if($nivel1 > 0 ){
            $sql .= " AND cp.nsecundario_id in
            (select ns.id
            from nivel_secundario ns
            join nivel_primario np on ns.nprimario_id = np.id and np.id = $nivel1) group by ec.nombre";
        }else{
            $sql .= " AND cp.nsecundario_id in (select id from nivel_secundario where nprimario_id in ($permiso_np)) group by ec.nombre";
        }
        return DB::select($sql);
    }

    public function estado_comercial_mes(Request $request)
    {
        #return DB::select('SELECT ec.nombre, count(ec.nombre) as total from contacto_historicos ch join estado_comercial ec on ch.estado_comercial_id = ec.id where MONTH(ch.created_at) = MONTH(getdate()) group by ec.nombre');
        $nivel1 = session('d_nivel1');
        $permiso_np = isset($this->permiso_np) ? implode(',',$this->permiso_np) : 0; 

        $sql = "SELECT ec.nombre, count(ec.nombre) as total from (
            select id, contacto_tipo_id,
            estado_comercial_id, vendedor_id,campana_programa_id,created_at,
            row_number() over(partition by contacto_tipo_id order by id desc) as rn
            from contacto_historicos
            ) as T join tipo_contactos tc on T.contacto_tipo_id  = tc.id
            join estado_comercial ec on T.estado_comercial_id = ec.id
            join campana_programa cp on T.campana_programa_id = cp.id
            join nivel_secundario ns on cp.nsecundario_id = ns.id
            join nivel_primario np on ns.nprimario_id = np.id
            join contactos co on tc.contacto_id = co.id
            where rn = 1 and co.estado ='A' and tc.tipo_id = 1 AND MONTH(T.created_at) = MONTH(getdate()) ";
        if($request->periodo > 0 ){
            $sql .= " AND YEAR(T.created_at) = (select anio from periodos where id = '".$request->periodo."') ";
        }
        if($nivel1 > 0 ){
            $sql .= " AND cp.nsecundario_id in
            (select ns.id
            from nivel_secundario ns
            join nivel_primario np on ns.nprimario_id = np.id and np.id = $nivel1) group by ec.nombre";
        }else{
            $sql .= " AND cp.nsecundario_id in (select id from nivel_secundario where nprimario_id in ($permiso_np)) group by ec.nombre";
        }
        return DB::select($sql);

    }

    public function oferta(Request $request)
    {
        #return DB::select("SELECT ns.nombre, count(ns.nombre) as total  from contacto_historicos ch join estado_comercial ec on ch.estado_comercial_id = ec.id join campana_programa cp on ch.campana_programa_id = cp.id join nivel_secundario  ns on cp.nsecundario_id = ns.id join nivel_primario np on ns.nprimario_id = np.id where np.id = ".$request->id." and ns.nombre is not null group by ns.nombre");
        return DB::select("SELECT  ns.nombre, count(ns.nombre) as total  from (
            select id, contacto_tipo_id,
            estado_comercial_id, vendedor_id,campana_programa_id,
            row_number() over(partition by contacto_tipo_id order by id desc) as rn
            from contacto_historicos
            ) as T join tipo_contactos tc on T.contacto_tipo_id  = tc.id
            join campana_programa cp on T.campana_programa_id = cp.id
            join nivel_secundario ns on cp.nsecundario_id = ns.id
            join nivel_primario np on ns.nprimario_id = np.id
            join contactos co on tc.contacto_id = co.id
            where rn = 1 and co.estado ='A' and tc.tipo_id = 1 AND  np.id = " . $request->id . " group by ns.nombre");
    }

    public function estado(Request $request)
    {
        /*return DB::select("SELECT ec.nombre, count(ec.nombre) as total  from contacto_historicos ch join estado_comercial ec on ch.estado_comercial_id = ec.id join campana_programa cp on ch.campana_programa_id = cp.id join nivel_secundario  ns on cp.nsecundario_id = ns.id join nivel_primario np on ns.nprimario_id = np.id where np.id = ".$request->id." group by ec.nombre");*/
        return DB::select("SELECT ec.nombre, count(ec.nombre) as total  from (
            select id, contacto_tipo_id,
            estado_comercial_id, vendedor_id,campana_programa_id,created_at,
            row_number() over(partition by contacto_tipo_id order by id desc) as rn
            from contacto_historicos
            ) as T join tipo_contactos tc on T.contacto_tipo_id  = tc.id
            join estado_comercial ec on T.estado_comercial_id = ec.id 
            join campana_programa cp on T.campana_programa_id = cp.id
            join nivel_secundario  ns on cp.nsecundario_id = ns.id 
            join nivel_primario np on ns.nprimario_id = np.id 
            join contactos co on tc.contacto_id = co.id
            where rn = 1 and co.estado ='A' and np.id = " . $request->id . " and tc.tipo_id = 1 group by ec.nombre");
    }
}
