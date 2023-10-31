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
                                        texto-ajuda="Opcional. Informe o ID da cliente.">
                                        <input type="number" class="form-control" id="imputId" aria-describedby="idHelp"
                                            placeholder="ID" />
                                    </imput-container>
                                </div>
                                <div class="col mb-3">
                                    <imput-container titulo="Nome da Cliente" id="imputNome" id-help="nomeHelp"
                                        texto-ajuda="Opcional. Informe o nome da cliente.">
                                        <input type="text" class="form-control" id="imputNome" aria-describedby="nomeHelp"
                                            placeholder="Nome da cliente" />
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
            <!--Fim do card busca de clientes-->

            <!--Inicio do card listagem de marcas-->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <card titulo="Relação de Clientes">
                            <template v-slot:conteudo>
                                <table-component :dados="clientes.data"
                                :visualizar="{visivel: true, dataToggle: 'modal', dataTarget:'#modalClienteVisualizar'}"
                                :atualizar="true"
                                :remover="{visivel: true, dataToggle: 'modal', dataTarget:'#modalClienteRemover'}"
                                :titulos="{
                                id: { titulo: 'ID', tipo: 'texto' },
                                nome: { titulo: 'Nome', tipo: 'texto' },
                                created_at: { titulo: 'Data Criação', tipo: 'data' },
                                }"></table-component>
                            </template>
                            <template v-slot:rodape>
                                <div class="col-10">
                                    <paginate-component>
                                        <li v-for="l, key in this.clientes.links" :key="key"
                                            :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)"><a class="page-link"
                                            v-html="l.label"></a></li>
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
                    <!--Fim do card listagem de marcas-->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'
    import Alert from './Alert.vue'
    export default{
        components: { Alert },
        data(){
            return {
                urlBase: 'http://localhost/api/v1/cliente',
                urlPaginacao: '',
                urlFiltro: '',
                nomeCliente: '',
                clientes: { data: [] },
                busca: { id: '', nome: '' }
            }
        },
        methods: {
            paginacao(l) {
                if (l.url) {
                    //this.urlBase = l.url //ajustando a url de consulta com o parâmetro de página
                    this.urlPaginacao = l.url.split('?')[1]
                    //this.carregarLista() //requisitando novamente os dados para nossa API
                }
            },
            carregarLista() {

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

                axios.get(url)
                .then(response => {
                    console.log(response.data)
                    this.clientes = response.data
                    //console.log(this.clientes)
                })
                .catch(erros => {
                    console.log(erros)
                })
            },
        },
        mounted() {
            this.carregarLista()
        }
    }
</script>
