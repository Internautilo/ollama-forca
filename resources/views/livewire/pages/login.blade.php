<div class="container mt-5" style="max-width: 500px">
    @if(session('error'))
        <div class="alert alert-danger">
            É necessário estar autenticado para acessar a página
        </div>
    @endif

    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Fazer login</h3>
        </div>


        <form id="quickForm" wire:submit="login">
            <div class="card-body">
                <div class="form-group">
                    <label for="email">Endereço de Email</label>
                    <input type="email" wire:model.blur="form.email" class="form-control" id="email" placeholder="Digite seu email">
                    @error('form.email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" wire:model.blur="form.password" class="form-control" id="password" placeholder="Digite sua senha">
                    @error('form.password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-outline-secondary">Login</button>
            </div>
        </form>
    </div>
</div>
