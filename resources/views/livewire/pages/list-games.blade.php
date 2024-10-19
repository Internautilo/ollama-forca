
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
                        <table id="example2" class="table table-bordered table-hover table-striped dataTable dtr-inline collapsed"
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
                                    aria-label="Platform(s): activate to sort column ascending">Conclusão
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($games as $game)
                                <tr class="odd">
                                    <td class="dtr-control sorting_1" tabindex="0">{{ $game->theme }}</td>
                                    <td>{{ $game->keyword }}</td>
                                    <td>{{ $game->correct_letters }}</td>
                                    <td class="d-flex justify-content-around align-items-center">
                                        <a style="width: 40%" class="btn btn-light" wire:navigate href="{{ route("game", [$id => $game->id]) }}"><i class="fas fa-play"></i></a>
                                        <a style="width: 40%" class="btn btn-danger" wire:navigate><i class="fas fa-trash"></i></a>
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
    $(function () {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "columnDefs": [
                { "orderable": false, "targets": 3 }
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
    });
</script>
@endscript
