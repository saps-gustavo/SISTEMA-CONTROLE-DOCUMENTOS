<?php

namespace App;

use App\Configuracao;
use Illuminate\Database\Eloquent\Model;

/**
 * Representa o Token utilizado para autorizar a comunicação externa com a aplicação.
 */
class Token extends Model
{
    /** Constantes utilizadas no processo de cripografia */
    const CRYPTO_SSL_CHAVE = 'umanelparatodosgovernarumanelpar';
    const CRYPTO_SSL_IV = 'umanelparaatodos';

    /** Indica por quanto tempo o Token é válido (em minutos) */
    const TOKEN_EXPIRACAO = Configuracao::TIMEOUT_PROCESSAMENTO_CARGA / 60;

    /** Configurações do model eloquent */
    protected $connection = 'pgsqlsicom';
    protected $table = 'token';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'cliente',
        'ip',
        'dt_criacao',
        'token',
    ];

    /**
     * Salva token recebido depois de validar se o mesmo foi
     * corretamente criptografado.
     */
    public static function salvar($cliente, $request)
    {
		$token = $request->input('token');
		$valorToken = self::decrypt($token);
        if (empty($valorToken)) {
            return false;
        }

        self::removerExpirados($cliente);

        $novoToken = new Token();
        $novoToken->cliente = $cliente;
        $novoToken->ip = $request->ip();

        $agora = new \DateTime();
        $novoToken->dt_criacao = $agora->format('Y-m-d\TH:i:s');

        $novoToken->token = $valorToken;
        $novoToken->save();

        return true;
    }

    /**
     * Verifica se o token foi autorizado, retornando true caso positivo.
     */
    public static function autorizado($request)
    {
		$tokenRecebido = $request->input('token');
        $valorToken = self::decrypt($tokenRecebido);
        if (empty($valorToken)) {
            return false;
        }

        $data = new \DateTime();
        $data->sub(new \DateInterval('PT' . self::TOKEN_EXPIRACAO . 'M'));

        $tokensAutorizados = self::where('token', $valorToken)
            ->where('dt_criacao', '>=', $data->format('Y-m-d\TH:i:s'))
            ->count();

        return $tokensAutorizados > 0;
    }

    /**
     * Remove tokens do cliente especificado que já expiraram.
     */
    private static function removerExpirados($cliente)
    {
        if (!empty($cliente)) {
            $data = new \DateTime();
			$data->sub( new \DateInterval('PT' . self::TOKEN_EXPIRACAO . 'M') );

            self::where('cliente', $cliente)
                ->where('dt_criacao', '<', $data->format('Y-m-d\TH:i:s'))
                ->delete();
        }
    }

    /**
     * Retorna string criptografada via OpenSSL (AES-256-CBC).
     * Por exemplo, equivalente ao comando:
     *   $ echo foobar|openssl enc -aes-256-cbc -a -K 756d616e656c70617261746f646f73676f7665726e6172756d616e656c706172 -iv 756d616e656c7061726161746f646f73
     */
    private static function encrypt($data)
    {
        $iv = bin2hex(self::CRYPTO_SSL_IV);
        $dataMixed = $data;

        $encrypted = openssl_encrypt($dataMixed, 'AES-256-CBC', self::CRYPTO_SSL_CHAVE, 0, hex2bin($iv));
        return $encrypted;
    }

    /**
     * Retorna string descriptografada por meio de OpenSSL (AES-256-CBC).
     * Por exemplo, equivalente ao comando:
     *   $ echo kztsYMSCCk6GuhIUoLDtKA==|openssl enc -aes-256-cbc -d -a -K 756d616e656c70617261746f646f73676f7665726e6172756d616e656c706172 -iv 756d616e656c7061726161746f646f73
     */
    private static function decrypt($data)
    {
        $iv = bin2hex(self::CRYPTO_SSL_IV);

        $decrypted = openssl_decrypt($data, 'AES-256-CBC', self::CRYPTO_SSL_CHAVE, 0, hex2bin($iv));

        if ($decrypted === false) {
            return '';
        }

        return str_replace("\n", '', $decrypted);
    }
}
