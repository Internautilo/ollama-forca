@php

function calcPercentage(string $word, string $correctLetters, bool $descriptive = false): float|string
{
    if ($correctLetters === '') {
        if ($descriptive) {
            return 0 . ' / ' . strlen($word);
        }
        return 0;
    }

    $letrasCorretas = 0;
    $correctLettersArray = explode(',', $correctLetters);
    $uniqueLetters = array_unique(array_map('strtolower', $correctLettersArray));

    foreach ($uniqueLetters as $letter) {
        $letrasCorretas += substr_count(strtolower($word), strtolower($letter));
    }

    if ($descriptive) {
        return $letrasCorretas . ' / ' . strlen($word);
    }

    if (strlen($word) > 0) {
        $response = ($letrasCorretas / strlen($word)) * 100;
        return number_format($response, 2);
    }
    return 0;
}

function proccessKeyword(string $keyword, string $foundLetters): string
{
    $foundLetters = array_map('strtoupper', explode(',', $foundLetters));
    for ($i = 0; $i < strlen($keyword); $i++) {
        $currentLetter = strtoupper($keyword[$i]);

        if (!in_array($currentLetter, $foundLetters)) {
            $keyword[$i] = '*';
        }
    }
    return $keyword;
}

@endphp

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Jogos</h3>
        </div>

        <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example2"
                               class="table table-bordered table-hover dataTable dtr-inline collapsed"
                               aria-describedby="example2_info">
                            <thead>
                            <tr>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Rendering engine: activate to sort column ascending"
                                    aria-sort="descending">Tema do Jogo
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Palavra
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending">Progresso
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending">Tentativas
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($games as $game)
                                <tr class="odd">
                                    <td class="" tabindex="0">{{ $game->theme }}</td>
                                    <td>{{ proccessKeyword($game->keyword, $game->correct_letters ?: '') }}</td>
                                    <td>
                                        <div class="progress mb-2">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                 style="width: {{ calcPercentage($game->keyword, $game->correct_letters ?: '') }}%">
                                            </div>
                                        </div>
                                        {{ calcPercentage($game->keyword, $game->correct_letters ?: '', true) }} Letras Encontradas
                                    </td>
                                    <td class="text-center">
                                        ( {{ count(explode(',', $game->tries)) }} )
                                    </td>
                                    <td class="d-flex justify-content-around align-items-center">
                                        <a style="width: 45%" class="btn btn-default" wire:navigate
                                           href="{{ route("game", ['id' => $game->id]) }}"><i
                                                class="fas fa-play"></i></a>
                                        <button onclick="Livewire.find('{{ $this->getId() }}').deleteGame({{ $game->id }})"
                                                class="btn btn-danger" style="width: 45%">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    if ($('.dataTables_info')) {
        $('.dataTables_info').parent().parent().remove();
    }
    $('#example2').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": false,
        "scrollX": true,
        "columnDefs": [
            {"orderable": false, "targets": 3}
        ],
        "language": {
            "emptyTable": "Nenhum registro encontrado",
            "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "infoFiltered": "(Filtrados de _MAX_ registros)",
            "infoThousands": ".",
            "loadingRecords": "Carregando...",
            "zeroRecords": "Nenhum registro encontrado",
            "search": "Pesquisar",
            "paginate": {
                "next": "Próximo",
                "previous": "Anterior",
                "first": "Primeiro",
                "last": "Último"
            },
            "aria": {
                "sortAscending": ": Ordenar colunas de forma ascendente",
                "sortDescending": ": Ordenar colunas de forma descendente"
            },
        },
    });
</script>
@endscript
