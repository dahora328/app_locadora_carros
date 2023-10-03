<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!--Inicio do card busca de marcas-->
        <div class="card mb-3">
          <card titulo="Busca de marcas">
            <template v-slot:conteudo>
              <div class="row g-3">
                <div class="col mb-3">
                  <imput-container
                    titulo="ID"
                    id="imputId"
                    id-help="idHelp"
                    texto-ajuda="Opcional. Informe o ID da marca."
                  >
                    <input
                      type="number"
                      class="form-control"
                      id="imputId"
                      aria-describedby="idHelp"
                      placeholder="ID"
                    />
                  </imput-container>
                </div>
                <div class="col mb-3">
                  <imput-container
                    titulo="Nome da Marca"
                    id="imputNome"
                    id-help="nomeHelp"
                    texto-ajuda="Opcional. Informe o nome da marca."
                  >
                    <input
                      type="text"
                      class="form-control"
                      id="imputNome"
                      aria-describedby="nomeHelp"
                      placeholder="Nome da marca"
                    />
                  </imput-container>
                </div>
              </div>
            </template>
            <template v-slot:rodape>
              <button type="submit" class="btn btn-primary btn-sm me-md-2">
                Pesquisar
              </button>
            </template>
          </card>
          <div class="card-header"></div>
          <div class="card-body">
            <div
              class="card-footer d-grid gap-2 d-md-flex justify-content-md-end"
            ></div>
          </div>
        </div>
      </div>
      <!--Fim do card listagem de marcas-->
      <!--Inicio do card listagem de marcas-->
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card mb-3">
          <card titulo="Relação de Marcas">
            <template v-slot:conteudo>
              <table-compoent></table-compoent>
            </template>
            <template v-slot:rodape>
              <button type="submit" class="btn btn-primary btn-sm me-md-2">
                Adicionar
              </button>
            </template>
          
          </card>
        </div>
          <!--Fim do card listagem de marcas-->
        </div>
      </div>
    </div>
  </div>
</template>
  <script>
import InputContainer from "./ImputContainer.vue";
</script>