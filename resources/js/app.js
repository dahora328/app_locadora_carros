/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createStore } from 'vuex'
import { createApp } from 'vue';
import Login from './components/Login.vue';
import Home from './components/Home.vue';
import Marcas from './components/Marcas.vue'
import ImputContainer from './components/ImputContainer.vue';
import Table from './components/Table.vue';
import Card from './components/Card.vue';
import Modal from './components/Modal.vue';
import Alert from './components/Alert.vue';
import Paginate from './components/Paginate.vue';
<<<<<<< HEAD
import Clientes from './components/Clientes.vue';
=======
import Cliente from './components/Cliente.vue';
>>>>>>> 740c707bee5e1a0cefebad587d603e40aa6df5c4

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */


const app = createApp();

const store = createStore({
    state: {
        item: {},
<<<<<<< HEAD
        transacao: { status: '', mensagem: ''}
    }
})
=======
        transacao: { status: '', mensagem: '', dados: ''}
    } 
}) 
>>>>>>> 740c707bee5e1a0cefebad587d603e40aa6df5c4
app.use(store)

app.config.globalProperties.$filters = {
    formataDataTempo(date){
        if(!date){
          return ''
        }
        //T separa data do tempo 
        date = date.split('T');

        //formatando a data
        let dataFormatada = date[0]
        dataFormatada = dataFormatada.split('-')
        dataFormatada = dataFormatada[2] + '/' + dataFormatada[1] + '/' + dataFormatada[0]

        //formatando a hora
        let horaFormatada = date[1]
        horaFormatada = horaFormatada.split('.')
        horaFormatada = horaFormatada[0]

        //formatação final data e hora
        let dataFinal = dataFormatada + ' ' +horaFormatada

        return dataFinal
      }
}


import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);
app.component('login', Login);
app.component('home', Home);
app.component('marcas', Marcas);
app.component('imputContainer', ImputContainer);
app.component('table-component', Table);
app.component('card', Card);
app.component('modal-component', Modal);
app.component('alert-component', Alert);
app.component('paginate-component', Paginate);
<<<<<<< HEAD
app.component('clientes-component', Clientes);
=======
app.component('cliente-component', Cliente);
>>>>>>> 740c707bee5e1a0cefebad587d603e40aa6df5c4

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
