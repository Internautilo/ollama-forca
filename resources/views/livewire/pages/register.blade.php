<div class="container mt-5" style="max-width: 500px">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Criar Conta</h3>
        </div>


        <form id="quickForm" wire:submit="saveUser">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" wire:model.blur="form.name" class="form-control" id="name" placeholder="Digite seu nome">
                    @error('form.name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" wire:model.blur="form.email" class="form-control" id="email" placeholder="Digite seu email">
                    @error('form.email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" wire:model.blur="form.password" class="form-control" id="password" placeholder="Digite sua senha">
                    @error('form.password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
