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
                    <input type="number" class="form-control" id="imputId" aria-describedby="idHelp" placeholder="ID"
                      v-model="busca.id" />
                  </imput-container>
                </div>
                <div class="col mb-3">
                  <imput-container titulo="Nome da Marca" id="imputNome" id-help="nomeHelp"
                    texto-ajuda="Opcional. Informe o nome da marca.">
                    <input type="text" class="form-control" id="imputNome" aria-describedby="nomeHelp"
                      placeholder="Nome da marca" v-model="busca.nome" />
                  </imput-container>
                </div>
              </div>
            </template>
            <template v-slot:rodape>
              <button type="submit" class="btn btn-primary btn-sm me-md-2" @click="pesquisar()">
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
      <!--Fim do card busca de marcas-->

      <!--Inicio do card listagem de marcas-->
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card mb-3">
            <card titulo="Relação de Marcas">
              <template v-slot:conteudo>
                <table-component :dados="marcas.data"
                :visualizar="{visivel: true, dataToggle: 'modal', dataTarget:'#modalMarcaVisualizar'}"
                :atualizar="true"
                :remover="{visivel: true, dataToggle: 'modal', dataTarget:'#modalMarcaRemover'}"
                :titulos="{
                  id: { titulo: 'ID', tipo: 'texto' },
                  nome: { titulo: 'Nome', tipo: 'texto' },
                  imagem: { titulo: 'Imagem', tipo: 'imagem' },
                  created_at: { titulo: 'Data Criação', tipo: 'data' },
                }"></table-component>
              </template>
              <template v-slot:rodape>
                <div class="col-10">
                  <paginate-component>
                    <li v-for="l, key in this.marcas.links" :key="key"
                      :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)"><a class="page-link"
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


    <!--Inicio do modal de inclusão de marca -->
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
        </div>

        <div class="form-group">
          <imput-container id="novaImagem" id-help="novaImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
            <input type="file" class="form-control-file" id="novaImagem" aria-describedby="novaImagemHelp"
              placeholder="Selecione uma imagem" @change="carregarImagem($event)" />
          </imput-container>
        </div>
      </template>
      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
      </template>
    </modal-component>
    <!--Fim do modal de inclusão de marca -->

    <!--Inicio do modal de visualização de marca -->
    <modal-component id="modalMarcaVisualizar" titulo="Visualizar marca">
      <template v-slot:alertas></template>
      <template v-slot:conteudo>

        <imput-container titulo="ID">
          <input type="text" class="form-control" :value="$store.state.item.id" disabled>
        </imput-container>
        <imput-container titulo="Nome da Marca">
          <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
        </imput-container>
        <imput-container titulo="Imagem">
          <img :src="'storage/' + $store.state.item.imagem" v-if="$store.state.item.imagem">
        </imput-container>
        <imput-container titulo="Data de criação">
          <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
        </imput-container>

      </template>
      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </template>
    </modal-component>
    <!--Fim do modal de visualização de marca -->

    <!--Inicio do modal de remoção de marca -->
    <modal-component id="modalMarcaRemover" titulo="Remover marca">
      <template v-slot:alertas>
        <alert-component tipo="success" :detalhes="$store.state.transacao" titulo="Transação realizada com sucesso"
          v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
        <alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro na transação"
          v-if="$store.state.transacao.status == 'erro'"></alert-component>
      </template>
      <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">

        <imput-container titulo="ID">
          <input type="text" class="form-control" :value="$store.state.item.id" disabled>
        </imput-container>
        <imput-container titulo="Nome da Marca">
          <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
        </imput-container>
      </template>
      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" @click="remover()"
          v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
      </template>
    </modal-component>
    <!--Fim do modal de remoção de marca -->

    <!--Inicio do modal de atualização de marca -->
    <modal-component id="modalMarcaAtualizar" titulo="Atualizar marca">
      <template v-slot:alertas>
        <alert-component tipo="success" :detalhes="$store.state.transacao" titulo="Transação realizada com sucesso"
          v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
        <alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro na transação"
          v-if="$store.state.transacao.status == 'erro'"></alert-component>
      </template>
      <template v-slot:conteudo>
        <div class="form-group">
          <imput-container titulo="Nome da Marca" id="atualizarNome" id-help="atualizarNomeHelp"
            texto-ajuda="Informe o nome da marca.">
            <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp"
              placeholder="Nome da marca" v-model="$store.state.item.nome" />
          </imput-container>
        </div>

        <div class="form-group">
          <imput-container id="atualizarImagem" id-help="atualizarImagemHelp"
            texto-ajuda="Selecione uma imagem no formato PNG">
            <input type="file" class="form-control-file" id="atualizarImagem" aria-describedby="atualizarImagemHelp"
              placeholder="Selecione uma imagem" @change="carregarImagem($event)" />
          </imput-container>
        </div>
      </template>
      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
      </template>
    </modal-component>
    <!--Fim do modal de atualização de marca -->
  </div>
</template>
<script>
import axios from 'axios'
import Alert from './Alert.vue'
export default {
  components: { Alert },
  data() {
    return {
      urlBase: 'http://localhost/api/v1/marca',
      urlPaginacao: '',
      urlFiltro: '',
      nomeMarca: '',
      arquivoImagem: [],
      transacaoStatus: '',
      transacaoDetalhes: {},
      marcas: { data: [] },
      busca: { id: '', nome: '' }
    }
  },
  methods: {
    atualizar() {
      let formData = new FormData();
      formData.append('_method', 'patch')
      formData.append('nome', this.$store.state.item.nome)
      if (this.arquivoImagem[0]) {
        formData.append('imagem', this.arquivoImagem[0])
      }

      let url = this.urlBase + '/' + this.$store.state.item.id

      let config = {
        headers: {
          'Content-Type': 'multipart/form-data',
        }
      }

      axios.post(url, formData, config)
        .then(response => {

          //limpar os campo de seleção de arquivos
          atualizarImagem.value = ''
          this.$store.state.transacao.status = 'sucesso'
          this.$store.state.transacao.mensagem = 'Regsitro de ID: ' + this.$store.state.item.id + ' de marca atualizado com sucesso'
          this.carregarLista()
        })
        .catch(errors => {
          console.log('Erro de atualização', errors.response)
          this.$store.state.transacao.status = 'erro'
          this.$store.state.transacao.mensagem = errors.response.data.message
          this.$store.state.transacao.dados = errors.response.data.errors
        })
    },
    remover() {
      let confirmacao = confirm('Tem certeza que deseja remover o item ' + this.$store.state.item.nome)

      if (!confirmacao) {
        return false
      }

      let formData = new FormData();
      formData.append('_method', 'delete')


      let url = this.urlBase + '/' + this.$store.state.item.id

      axios.post(url, formData)
        .then(response => {
          this.$store.state.transacao.status = 'sucesso'
          this.$store.state.transacao.mensagem = response.data.msg
          this.carregarLista()
        })
        .catch(errors => {
          this.$store.state.transacao.status = 'erro'
          this.$store.state.transacao.mensagem = errors.response.data.erro
        })
    },
    pesquisar() {
      let filtro = ''

      for (let chave in this.busca) {
        if (this.busca[chave]) {
          if (filtro != '') {
            filtro += ";"
          }
          filtro += chave + ':like:' + this.busca[chave]
        }
        if (filtro != '') {
          this.urlPaginacao = 'page=1'
          this.urlFiltro = '&filtro=' + filtro
        } else {

          this.urlFiltro = ''
        }
      }
      this.carregarLista()
    },
    paginacao(l) {
      if (l.url) {
        //this.urlBase = l.url //ajustando a url de consulta com o parâmetro de página
        this.urlPaginacao = l.url.split('?')[1]
        this.carregarLista() //requisitando novamente os dados para nossa API
      }
    },
    carregarLista() {

      let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

      axios.get(url)
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
          this.carregarLista()
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
