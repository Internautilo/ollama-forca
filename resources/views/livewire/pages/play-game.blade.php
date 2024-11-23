@php
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

<div class="container align-items-center pb-3">
    <hr class="hr hr invisible"/>
    <div class="card card-cyan">
        <div class="card-header">
        </div>
        <form>
            <div class="card-body">
                <div class="form-group d-inline">
                    <strong>Tema:</strong>
                    '{{ $game->theme }}'
                </div><br/>
                <div class="form-group d-inline">
                    <strong>Tentativas:</strong>
                    ({{ count(explode(',', $game->tries)) }})
                    {{ $game->tries }}
                </div><br/>
                <div class="form-group d-inline">
                    <strong>Corretas:</strong>
                    ({{ count(explode(',', $game->correct_letter)) }})
                    {{ $game->correct_letters }}
                </div>
                <div class="d-flex justify-content-center align-items-center mt-5 mb-2">
                    <h5>Palavra</h5>
                </div>
                <div class="d-flex justify-content-center align-items-center mb-2">
                    <h2 id="keyword">{{ proccessKeyword($game->keyword, ($game->correct_letters) ?: '') }}</h2>
                </div>
                <div class="mb-1 d-flex justify-content-between">
                    <span><strong>Dica: </strong> {{ $extraTip ?: $this->game->tips }}</span>
                    <span><button type="button" class="btn btn-sm btn-primary" wire:click="askTip">Pedir mais dicas</button></span>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <input type="hidden" id="key" name="key" class="input" />
                    <div class="simple-keyboard"></div>
                </div>
            </div>
        </form>
    </div>
</div>

@script
<script data-navigate-once >
    const keyword = '{{ $game->keyword }}';
    let toastString = '{{ (!empty($_REQUEST['toast'])) ? $_REQUEST['toast'] : '' }}';
    toastString = decodeHtmlEntities(toastString);
    let toastParam = null;
    if (toastString !== '') {
        toastParam = JSON.parse(toastString);
    }
    if (toastParam) {
        Swal.fire(toastParam);
    }
    let letras = '{{ $game->correct_letters }}';
    let finalizado = false;
    if (letras === '') {
        letras = [];
    } else {
        letras = letras.trim().toUpperCase().split(',');
        const keyMap = new Map();

        for (let i = 0; i < keyword.length; i++) {
            const letra = keyword[i].toUpperCase();
            const found = letras.includes(letra);

            keyMap.set(i, [keyword[i], found]);
        }
    }

    function replaceLetter(letter) {
        if (letras.indexOf(letter) !== -1) {
            Swal.fire({
                icon: 'warning',
                title: 'Voce já tentou essa letra!',
                toast: true,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,
            });
            return;
        }

        let letraCorreta = false;
        let texto = keyword.split('');
        if (keyword.indexOf(letter) !== -1 && !finalizado) {
            letras.push(letter);
            letraCorreta = true;
        }
        for (let i = 0; i < texto.length; i++) {
            const letra = texto[i];
            if (!letras.includes(letra)) {
                texto[i] = '*';
            }
        }
        texto = texto.join('');
        document.querySelector('#keyword').textContent = texto;
        if (texto === keyword) {
            finalizado = true;
            Swal.fire({
                icon: 'success',
                title: 'Voce concluiu o desafio!',
                position: 'center',
                showDenyButton: true,
                confirmButtonText: 'Lista de Jogos',
                denyButtonText: 'Continuar',
                customClass: {
                    actions: 'my-actions',
                    confirmButton: 'order-2',
                    denyButton: 'order-1 bg-secondary',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('go-back-on-finish', {letter: letter});
                } else {
                    Livewire.find('{{ $this->id() }}').dispatch('add-correct-letter', {letter: letter});
                }
            });
            return;
        }

        if (letraCorreta) {
            Livewire.find('{{ $this->id() }}').dispatch('add-correct-letter', {
                letter: letter,
                toast: JSON.stringify({
                    icon: 'success',
                    title: 'Voce acertou!',
                    showConfirmButton: true,
                }),
            });
        } else {
            Livewire.find('{{ $this->id() }}').dispatch('add-try', {
                letter: letter,
                toast: JSON.stringify({
                    icon: 'error',
                    title: 'Tente novamente!',
                    showConfirmButton: true,
                }),
            });
        }
        Swal.fire({
           icon: 'warning',
           title: 'Carregando',
           toast: false,
           showConfirmButton: false,
        }).then(() => {
            myKeyboard.destroy();
        });
    }

    function onKeyPress(button) {
        myKeyboard.clearInput();
        replaceLetter(button);
    }

    const Keyboard = window.SimpleKeyboard.default;
    const myKeyboard = new Keyboard({
        onKeyPress: button => onKeyPress(button),
        layout: {
            'default': [
                'Q W E R T Y U I O P',
                'A S D F G H J K L',
                'Z X C V B N M',
            ],
            'shift': [
                'Q W E R T Y U I O P',
                'A S D F G H J K L',
                'Z X C V B N M',
            ]
        },
    });

    function decodeHtmlEntities(str) {
        return str.replace(/&quot;/g, '"')
            .replace(/&#39;/g, "'")
            .replace(/&amp;/g, "&")
            .replace(/&lt;/g, "<")
            .replace(/&gt;/g, ">");
    }


</script>
@endscript

