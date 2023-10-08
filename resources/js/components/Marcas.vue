<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!--Inicio do card busca de marcas-->
        <div class="card mb-3">
          <card titulo="Busca de marcas">
            <template v-slot:conteudo>
              <div class="row g-3">
                <div class="col mb-3">
                  <imput-container titulo="ID" id="imputId" id-help="idHelp"
                    texto-ajuda="Opcional. Informe o ID da marca.">
                    <input type="number" class="form-control" id="imputId" aria-describedby="idHelp" placeholder="ID" />
                  </imput-container>
                </div>
                <div class="col mb-3">
                  <imput-container titulo="Nome da Marca" id="imputNome" id-help="nomeHelp"
                    texto-ajuda="Opcional. Informe o nome da marca.">
                    <input type="text" class="form-control" id="imputNome" aria-describedby="nomeHelp"
                      placeholder="Nome da marca" />
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
            <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end"></div>
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
                <table-component :dados="marcas.data" :titulos="{
                  id: { titulo: 'ID', tipo: 'texto' },
                  nome: { titulo: 'Nome', tipo: 'texto' },
                  imagem: { titulo: 'Imagem', tipo: 'imagem' },
                  created_at: { titulo: 'Data Criação', tipo: 'data' },
                }"></table-component>
              </template>
              <template v-slot:rodape>
                <div class="col-10">
                  <paginate-component>
                    <li v-for="l, key in this.marcas.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)"><a class="page-link"
                        v-html="l.label"></a></li>
                  </paginate-component>
                </div>
                <div class="justify-content-md-end">
                  <button type="submit" class="btn btn-primary btn-sm me-md-2" data-bs-toggle="modal"
                    data-bs-target="#modalMarca">
                    Adicionar
                  </button>
                </div>
              </template>
            </card>
          </div>
          <!--Fim do card listagem de marcas-->
        </div>
      </div>
    </div>



    <modal-component id="modalMarca" titulo="Adicionar marca">
      <template v-slot:alertas>
        <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso"
          v-if="transacaoStatus == 'adicionado'"></alert-component>
        <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca"
          v-if="transacaoStatus == 'erro'"></alert-component>
      </template>
      <template v-slot:conteudo>
        <div class="form-group">
          <imput-container titulo="Nome da Marca" id="novoNome" id-help="novoNomeHelp"
            texto-ajuda="Informe o nome da marca.">
            <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
              placeholder="Nome da marca" v-model="nomeMarca" />
          </imput-container>
          {{ nomeMarca }}
        </div>

        <div class="form-group">
          <imput-container id="novaImagem" id-help="novaImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
            <input type="file" class="form-control-file" id="novaImagem" aria-describedby="novaImagemHelp"
              placeholder="Selecione uma imagem" @change="carregarImagem($event)" />
          </imput-container>
          {{ arquivoImagem }}
        </div>
      </template>
      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
      </template>
    </modal-component>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  computed: {
    //configuração do token
    token() {
      let token = document.cookie.split(';').find(indice => {
        return indice.includes('token=')
      })

      token = token.split('=')[1] //pega indice da posição 1

      token = 'Bearer ' + token


      return token
    }
  },
  data() {
    return {
      urlBase: 'http://localhost/api/v1/marca',
      nomeMarca: '',
      arquivoImagem: [],
      transacaoStatus: '',
      transacaoDetalhes: {},
      marcas: { data: [] },
    }
  },
  methods: {
    paginacao(l){
      if(l.url){
        this.urlBase = l.url //ajustando a url de consulta com o parâmetro de página
        this.carregarLista() //requisitando novamente os dados para nossa API
      }
    },
    carregarLista() {

      //Cabeçalho da requisição
      let config = {
        headers: {
          'Accept': 'application/json',
          'Authorization': this.token
        }
      }

      axios.get(this.urlBase, config)
        .then(response => {
          this.marcas = response.data
          //console.log(this.marcas)
        })
        .catch(erros => {
          console.log(erros)
        })
    },
    carregarImagem(e) {
      this.arquivoImagem = e.target.files
    },
    salvar() {
      console.log(this.nomeMarca, this.arquivoImagem[0])

      let formData = new FormData();
      formData.append('nome', this.nomeMarca)
      formData.append('imagem', this.arquivoImagem[0])

      //Cabeçalho da requisição
      let config = {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Accept': 'application/json',
          'Authorization': this.token
        }
      }

      //Verbo da requisição
      axios.post(this.urlBase, formData, config)
        .then(response => {
          this.transacaoStatus = 'adicionado'
          this.transacaoDetalhes = {
            mensagem: 'ID do registro: ' + response.data.id
          }
          console.log(response)
        })
        .catch(erros => {
          this.transacaoStatus = 'erro'
          this.transacaoDetalhes = {
            mensagem: erros.response.data.message,
            dados: erros.response.data.erros
          }
          //console.log(erros.response.data.message)
        })
    }
  },
  mounted() {
    this.carregarLista()
  }
}
</script>
