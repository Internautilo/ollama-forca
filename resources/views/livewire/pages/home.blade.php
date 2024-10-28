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
    @if(auth()->check())
        <h2 class="text-center my-5"> Bem vindo, {{ session()->get('user')->name }}</h2>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header bg-primary">Seus jogos</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Tema</td>
                                    <td>Progresso</td>
                                    <td></td>
                                </tr>
                            </thead>
                            @foreach($games as $game)
                                <tr>
                                    <td>{{ $game->theme }}</td>
                                    <td><div class="progress mb-2">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                 style="width: {{ calcPercentage($game->keyword, $game->correct_letters ?: '') }}%">
                                            </div>
                                        </div>
                                        {{ calcPercentage($game->keyword, $game->correct_letters ?: '', true) }} Letras Encontradas
                                    </td>
                                    <td>
                                        <a style="" class="btn btn-default" wire:navigate
                                           href="{{ route("game", ['id' => $game->id]) }}" >
                                            <i class="fas fa-play"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <a href="{{ route('list-games') }}" class="btn btn-primary mt-3" wire:navigate>Ver todos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <livewire:pages.new-game-form />
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col text-center">
                                    <a href="{{ route('new-game') }}" class="btn btn-primary">Novo Jogo</a>
                                </div>
                                <div class="col text-center">
                                    <a href="{{ route('list-games') }}" class="btn btn-default">Lista de jogos</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container pb-5">
            <h2 class="text-center my-5">Jogos Recentes</h2>
            <table class="table table-bordered">
                <thead>
                <tr class="font-weight-bold">
                    <td>Tema</td>
                    <td>Progresso</td>
                    <td>Criado em</td>
                </tr>
                </thead>
                @foreach($games as $game)
                    <tr>
                        <td>{{ $game->theme }}</td>
                        <td><div class="progress mb-2">
                                <div class="progress-bar bg-danger" role="progressbar"
                                     style="width: {{ calcPercentage($game->keyword, $game->correct_letters ?: '') }}%">
                                </div>
                            </div>
                            {{ calcPercentage($game->keyword, $game->correct_letters ?: '', true) }} Letras Encontradas
                        </td>
                        <td>{{ $game->created_at }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
</div>
