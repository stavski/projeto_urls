<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Url;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = Url::where('user_id', Auth::user()->id)->get();

        return view('urls.index', compact('urls'));
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

            return redirect()->back()->with('success', 'Url cadastrada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
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
        //
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

            return redirect('urls')->with('success', 'Url editada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
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

            return redirect()->back()->with('success', 'Sucesso!');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Não foi possível excluir a url');
        }
    }
}
