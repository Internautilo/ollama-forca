<div class="container align-items-center">
    <hr class="hr hr invisible"/>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Criação de Jogo</h3>
        </div>
        <form wire:submit="save">
            <div class="card-body">
                <div class="form-group">
                    <label for="tema">Tema do Jogo</label>
                    <textarea class="form-control" id="tema" name="tema" wire:model="theme"
                              placeholder="Digite um tema para a palavra do jogo"></textarea>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary">Iniciar Jogo</button>
            </div>
        </form>
    </div>
</div>
