<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogAtividades;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('VerifyCsrfToken');

        return view('home');
    }

    /* Método para log do sistema */
    public function logAtividade(Request $request)
    {
        try{
            if(!auth()->user()->can('log_sistema')){
                \Session::flash('mensagem',['msg'=>'Você não tem permissão para visualizar os Logs do sistema!']);
                return redirect('/');
            }

            $lista = LogAtividades::query();

            //buscas e filtros
            $parametros = $request->all();

            // Período: datainicio, datafim
            if (isset($parametros['datainicio']) && isset($parametros['datafim'])) {

                $datainicio = implode('-',array_reverse(explode('/', $parametros['datainicio']))).' 00:00:00';
                $datafim = implode('-',array_reverse(explode('/', $parametros['datafim']))).' 23:59:59';

                //passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
                $lista = $lista->where(function ($query) use ($datainicio, $datafim) {
                    $query->whereBetween(\DB::raw('created_at'), [$datainicio , $datafim]);
                });
            }else{
                $parametros['datainicio'] = "";
                $parametros['datafim'] = "";
            }
            
            // Ação: acao
            if (isset($parametros['acao'])) {
                $acao = $parametros['acao'];
                //passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
                $lista = $lista->where(function ($query) use ($acao) {
                    $query->where(\DB::raw('acao'), 'like', $acao.'%');
                });
            } else {
                $parametros['acao'] = "";
            }
            
            // Usuário: usuario
            if (isset($parametros['usuario'])) {
                $usuario = $parametros['usuario'];
                //passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
                $lista = $lista->where(function ($query) use ($usuario) {
                    $query->where(\DB::raw('id_usuario'), '=', $usuario);
                });
            } else {
                $parametros['usuario'] = "";
            }

            //Verifica se exibe o SAPS ou não
            $usuario_logado = auth()->user();
            if ($usuario_logado->id_usuario <> env('ID_USUARIO_SAPS')) {
                $id_usuario_saps = env('ID_USUARIO_SAPS');
                //passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
                $lista = $lista->where(function ($query) use ($id_usuario_saps) {
                    $query->where(\DB::raw('id_usuario'), '<>', $id_usuario_saps);
                });
            }

            $qtd_registros = $lista->count();

            $logs = $lista->orderBy('created_at', 'desc')->paginate(getenv('paginacao'))->appends($request->query());

            $anos = array();
            for ($i = 2015; $i <= (date("Y") + 1); $i++) {
                $anos[] = $i;
            }

            $usuarios = User::query()->orderby('nome_usuario')->get();

            $titulo = "Log do Sistema";
            $subtitulo = "Página Inicial";
        
            return view('admin.log.index', compact('logs', 'titulo', 'subtitulo', 'anos', 'qtd_registros', 'usuarios', 'parametros'));

        }catch(\Exception $e)
        {
            $msg = str_replace("\n", "", $e->getMessage());
            \Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);

            return redirect('/');
        }
    }

    public function logDetalhe($id)
    {
        try{
            $log = LogAtividades::find($id);

            $titulo = "Principal";
            $subtitulo = "Logs";
            
            return view('admin.log.detalhe',compact ('log','titulo','subtitulo'));

        }catch(\Exception $e)
        {
            $msg = str_replace("\n", "", $e->getMessage());
            \Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);

            return redirect('/');
        }
    }

    public function testeCurl()
    {
        $curl = curl_init();

        dump($curl);
    }
}
