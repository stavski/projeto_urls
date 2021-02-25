@if (isset($urls) && $urls) 
    @foreach($urls as $url)
        <tr>
            <td>
                {{ $url->url }}
            </td>
            <td>
                {{ $url->status_http ?? '-' }}
            </td>
            <td>
                @if (isset($url->data_acesso ))
                    {{ date( 'd/m/Y H:i:s' , strtotime($url->data_acesso )) }}
                @else
                    -
                @endif
            </td>
            <td>
                <a href="{{ url("urls/$url->id/edit") }}" class="btn btn-sm btn-primary" type="button" title="Editar url"> 
                    Editar
                </a>
                <a href="{{ url("urls/$url->id") }}" target="_blank" class="btn btn-sm btn-success detalhe" type="button" title="Ver detalhe"> 
                    Detalhe
                </a>
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