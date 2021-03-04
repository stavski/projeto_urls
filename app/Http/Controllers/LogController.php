<?php

namespace App\Http\Controllers;

use App\Log;
use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpClient\HttpClient;

class LogController extends Controller
{
    public static function insertLogSystem($descricao = Null, $urlCorreta = Null)
    {
        /* Verifica qual é o tipo do log, inserção, update ou exclusão de dados */
        if (is_object($descricao) && $descricao->wasRecentlyCreated) {
            // INSERT
            $tipo = 1;
        } else {
            // UPDATE
            $tipo = 2;
        }

        if (!is_object($descricao)) {
            // DELETE
            $tipo = 3;
        }

        $log             = new Log();
        $log->user_id    = Auth::user()->id;
        $log->rota       = $urlCorreta ?? \Request::getRequestUri();
        $log->tipo       = $tipo;
        $log->descricao  = json_encode($descricao);

        return $log->save();
    }
}
