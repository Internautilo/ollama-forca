<div class="container mt-5" style="max-width: 500px">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Criar Conta</h3>
        </div>


        <form id="quickForm" novalidate="novalidate">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Digite seu nome">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group mb-0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                        <label class="custom-control-label" for="exampleCheck1">Eu concordo com os <a href="#">termos de serviço</a>.</label>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

@script
<script>
    $('#quickForm').on('submit', () => {

        Swal.fire({
            icon: 'success',
            title: 'Cadastrado com sucesso!',
            timerProgressBar: true,
            showConfirmButton: true,
            showCancelButton: false,
        }).then((result) => {
            Livewire.find('{{ $this->id() }}').dispatch('save', {
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('password').val(),
            });
        });
    });
</script>
@endscript
