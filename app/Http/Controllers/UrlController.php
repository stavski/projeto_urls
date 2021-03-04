<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Url;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpClient\HttpClient;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('urls.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('urls.createUrl');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UrlRequest $request)
    {
        try {
            $url            = new Url();
            $url->user_id   = Auth::user()->id;
            $url->url       = $request->url;
            $url->save();
            LogController::insertLogSystem($url);

            return redirect('urls')->with('success', 'Url cadastrada com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Não foi possível salvar a url');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function show(Url $url)
    {
        if (!$url) {
            return redirect()->back()->with('warning', 'Url não encontrada');
        }

        if ($url['status_http'] != 200) {
            return view('layouts.404');
        }

        return view('urls.showUrl', compact('url'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function edit(Url $url)
    {
        if (!$url) {
            return redirect()->back()->with('warning', 'Url não encontrada');
        }

        return view('urls.editUrl', compact('url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function update(UrlRequest $request, Url $url)
    {
        if (!$url) {
            return redirect()->back()->with('warning', 'Url não encontrada');
        }

        try {
            $url->url = $request->url;
            $url->save();
            LogController::insertLogSystem($url);

            return redirect('urls')->with('success', 'Url editada com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Não foi possível editar a url');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $url)
    {
        try {
            Url::where("id", $url->id)->where("user_id", Auth::user()->id)->delete();
            LogController::insertLogSystem();

            return redirect()->back()->with('success', 'Sucesso!');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Não foi possível excluir a url');
        }
    }

    /**
     * Pega todas as URLs do usuário logado e mostra na tela
     */
    public function showUserUrls(Request $request)
    {
        $urls = Url::where('user_id', Auth::user()->id)->get();

        return view('urls.tabelUrls', compact('urls'));
    }

    /**
     * Verifica o status de cada URLs cadastrado pelo usuário logado
     */
    public function checkUrls()
    {
        $urls = Url::where('user_id', Auth::user()->id)->get();

        if (isset($urls) && count($urls) > 0) {
            foreach ($urls as $url) {
                try {
                    $client      = HttpClient::create();
                    $request     = $client->request('GET', $url['url']);
                    $status_code = $request->getStatusCode();
                    $content     = $request->getContent();
                } catch (Exception $e) {
                    $status_code = '404';
                    $content     = '';
                }

                // Salvar o retorno no banco
                $att_url               = Url::find($url['id']);
                $att_url->status_http  = $status_code;
                $att_url->corpo_html   = utf8_encode($content);
                $att_url->data_acesso  = date('Y-m-d H:i:s'); 
                $att_url->save();
            }
        }
    }
}
