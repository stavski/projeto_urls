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
                        <button onclick="carregaTabela()" class="btn btn-sm btn-warning" type="button" title="Atualizar página"> 
                            Refresh
                        </button>
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
                                    <th>Data acesso</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>
                            <tbody id="resultadoTabela">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function carregaTabela() {
        $("#resultadoTabela").load("urls-usuario",{_token: "{{ csrf_token() }}"}, function () {});
    }

    function deletarUrl(id) {
        let excuir = confirm("Deseja excluir a url?");

        if (excuir) {
            document.getElementById(id).submit();
        }
    }

    $(document).ready(function() {
        // Carrega a tabela ao entrar na página
        carregaTabela();

        // Recarrega tabela a cada 5s
        window.setInterval(carregaTabela, 5000);
    });
</script>
@endsection

