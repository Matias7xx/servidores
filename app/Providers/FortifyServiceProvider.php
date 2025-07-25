<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        /* ---------- Views ---------- */
        Fortify::loginView(fn() => view('auth.login'));

        /* ---------- Ações ---------- */
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        /* ---------- Rate‑limit ---------- */
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->matricula . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        /* ---------- Autenticação personalizada ---------- */
        Fortify::authenticateUsing(function (Request $request) {
            try {
                /* 1. Procura o servidor na base do RH */
                $servidor = Servidor::where('matricula', $request->matricula)
                    ->first();

                /* 2. Se o servidor foi encontrado, verifica o status, caso seja Inativo, verifica se ele existe no banco local (caso positivo, atualiza o status para Inativo), caso seja Ativo, prossegue a autenticação */
                if ($servidor) {

                    if ($servidor->status == 'I') {
                        $user = User::where('matricula', $servidor->matricula)->first();
                        $user->update(['status' => 'Inativo']);
                        return null; // força erro de autenticação
                    } else {
                        /*verificação de senha*/
                        if (Hash::check($request->password, $servidor->senha)) {
                            /* Transforma o modelo em array (ou use $servidor->campo) */
                            $servidor_dados = $servidor->toArray();

                            /* 3. Verifica se já existe usuário local */
                            $user = User::where('matricula', $servidor_dados['matricula'])->first();

                            /*salvar a imagem do servidor na sessão*/
                            $url_foto = Storage::disk('s3')->temporaryUrl("funcionais/{$servidor_dados['cpf']}_F.jpg", now()->addMinutes(5));
                            session()->put('foto_servidor', $url_foto);
                            session()->put('servidor_nome', $servidor_dados['nome']);

                            if ($user) {

                                if ($user->status == 'Inativo') {
                                    $user->update(['status' => 'Ativo']);
                                }

                                $user->update([
                                    'unidade_lotacao_id'  => $servidor_dados['lotacao_principal']['codigo_unidade_lotacao'] ?? 340,
                                    'srpc'                => $servidor_dados['lotacao_principal']['srpc'] ?? 0,
                                    'dspc'                => $servidor_dados['lotacao_principal']['dspc'] ?? 0,
                                ]);

                                return $user;
                            } else {

                                /* 3B. Usuário não existe → cria */
                                $user = User::create([
                                    'servidor_id'        => $servidor_dados['id'],
                                    'name'               => $servidor_dados['nome'],
                                    'email'              => $servidor_dados['email']         ?: $servidor_dados['matricula'] . '@pc.pb.gov.br',
                                    'matricula'          => $servidor_dados['matricula'],
                                    'password'           => bcrypt($request->password),
                                    'role_id'            => 3,
                                    'cargo_id'           => $servidor_dados['codigo_cargo']   ?? null,
                                    'cargo'              => $servidor_dados['cargo']          ?? null,
                                    'status'             => $servidor_dados['status'],
                                    'cpf'                => $servidor_dados['cpf']            ?? null,
                                    'sexo'               => $servidor_dados['sexo']           ?? null,
                                    'unidade_lotacao_id' => $servidor_dados['lotacao_principal']['codigo_unidade_lotacao'] ?? 340,
                                    'srpc'               => $servidor_dados['lotacao_principal']['srpc'] ?? 0,
                                    'dspc'               => $servidor_dados['lotacao_principal']['dspc'] ?? 0,
                                    'nivel'              => $servidor_dados['lotacao_principal']['nivel'] ?? 0,
                                    'classe_funcional'   => $servidor_dados['classe_funcional'] ?? null,
                                    'nivel_funcional'    => $servidor_dados['nivel']           ?? null,
                                ]);
                            }
                            return $user; // autenticação OK
                        }
                    }
                } else {
                    /* 3. Se o servidor não foi encontrado, retorna null */
                    return null;
                }
            } catch (\Throwable $th) {
                Log::error($th);
                return null;
            }
        });
    }
}
