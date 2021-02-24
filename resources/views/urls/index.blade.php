@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Minhas URLs
                    <div style="float: right;">
                        <a href="urls/create" class="btn btn-sm btn-primary" type="button" title="Criar uma nova url"> 
                            Nova url
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="procedure_table" class="table table-bordered table-hover dtr-inline" style="width:100%">
                            <thead>
                                <tr class="text-primary">
                                    <th>Url</th>
                                    <th>Status</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($urls) && $urls) 
                                    @foreach($urls as $url)
                                        <tr>
                                            <td>
                                                {{ $url->url }}
                                            </td>
                                            <td>
                                                {{ $status->http ?? '-' }}
                                            </td>
                                           
                                            <td>
                                                <a href="{{ url("urls/$url->id/edit") }}" class="btn btn-sm btn-primary" type="button" title="Editar url"> 
                                                    Editar
                                                </a>
                                                <button class="btn btn-sm btn-success detalhe" type="button" title="Ver detalhe"> 
                                                    Detalhe
                                                </button>
                                                <button class="btn btn-sm btn-danger excluir" onclick="deletarUrl({{$url->id}})" type="button" title="Excluir url"> 
                                                    Excluir
                                                </button>
                                                <form id="{{$url->id}}" action="{{ route('urls.destroy',$url->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deletarUrl(id) {
        let excuir = confirm("Deseja excluir a url?");

        if (excuir) {
            document.getElementById(id).submit();
        }
    }
</script>
@endsection

