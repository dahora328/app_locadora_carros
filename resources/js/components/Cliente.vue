<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!--Inicio do card busca de clientes-->
                <div class="card mb-3">
                    <card titulo="Busca de clientes">
                        <template v-slot:conteudo>
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <imput-container titulo="ID" id="imputId" id-help="idHelp"
                                        texto-ajuda="Opcional. Informe o ID da marca.">
                                        <input type="number" class="form-control" id="imputId" aria-describedby="idHelp"
                                            placeholder="ID" />
                                    </imput-container>
                                </div>
                                <div class="col mb-3">
                                    <imput-container titulo="Nome do Cliente" id="imputNome" id-help="nomeHelp"
                                        texto-ajuda="Opcional. Informe o nome do cliente.">
                                        <input type="text" class="form-control" id="imputNome" aria-describedby="nomeHelp"
                                            placeholder="Nome do cliente" />
                                    </imput-container>
                                </div>
                            </div>
                        </template>
                    </card>
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end"></div>
                    </div>
                </div>
            </div>
            <!--Fim do card listagem de clientes-->
            <!--Fim do card listagem de clientes
            <div class="card mb-3">
                <card titulo="Relação de clientes">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="col-10">
                            <paginate-component>
                                
                            </paginate-component>
                        </div>
                        <div class="justify-content-md-end">
                            <button type="submit" class="btn btn-primary btn-sm me-md-2">
                                Adicionar
                            </button>
                        </div>
                    </template>
                </card>
            </div>
            Fim do card listagem de clientes-->
        </div>
    </div>
</template>
<script>

</script>