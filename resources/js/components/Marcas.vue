<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Busca de Marcas</div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col mb-3">
                <imput-container titulo="ID" id="imputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID da marca.">
                  <input
                    type="number"
                    class="form-control"
                    id="imputId"
                    aria-describedby="idHelp" placeholder="ID"
                  />
                </imput-container>
              </div>
              <div class="col mb-3">

                <imput-container titulo="Nome da Marca" id="imputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca.">
                  <input
                    type="text"
                    class="form-control"
                    id="imputNome"
                    aria-describedby="nomeHelp" placeholder="Nome da marca"
                  />
                </imput-container>
              </div>
              <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm me-md-2">Pesquisar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  <script>
import InputContainer from './ImputContainer.vue';
</script>