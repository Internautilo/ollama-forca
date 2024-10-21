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
                </div>
                <div class="d-flex justify-content-center align-items-center mt-5 mb-2">
                    <h5>Palavra</h5>
                </div>
                <div class="d-flex justify-content-center align-items-center mb-2">
                    <h2 id="keyword">{{ proccessKeyword($game->keyword, ($game->correct_letters) ?: '') }}</h2>
                </div>
                <div class="mb-1">
                    <strong>Dica: </strong> {{ $game->tips }}
                </div>
                <div class="form-group d-flex justify-content-center">
                    <input type="hidden" id="key" name="key" class="input" placeholder="Tap on the virtual keyboard to start" />
                    <div class="simple-keyboard"></div>
                </div>
            </div>
        </form>
    </div>
</div>

@script
<script>
    const keyword = '{{ $game->keyword }}';
    const $wire = Livewire.find('{{ $this->getId() }}');
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
        if (keyword.indexOf(letter) !== -1 && !finalizado) {
            let texto = keyword.split('');
            letras.push(letter);

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
                        Livewire.dispatch('redirect-to-route', {name: 'list-games', navigate: true});
                    }
                });
                return;
            }
            Swal.fire({
                icon: 'success',
                title: 'Voce acertou!',
                toast: true,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        } else if (finalizado) {
            Swal.fire({
                icon: 'warning',
                title: 'Desafio ja foi concluído!',
                toast: true,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Tente novamente!',
                toast: true,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        }
    }

    function onChange(input) {
        myKeyboard.clearInput();
        replaceLetter(input);
    }

    function onKeyPress(button) {
    }

    const Keyboard = window.SimpleKeyboard.default;
    const myKeyboard = new Keyboard({
        onChange: input => onChange(input),
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


</script>
@endscript
