<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <form class="card-body" v-if="editing" @submit.prevent="update">
                        <div class="card-title">
                            <input type="text" class="form-control form-control-lg" v-model="title" >
                        </div>

                        <hr>

                        <div class="media">
                            <div class="media-body">
                                <div class="form-group">
                                    <textarea class="form-control" v-model="body" rows="10"  required></textarea>
                                </div>
                                <button  class="btn btn-sm btn-outline-primary" :disabled="isInvalid">Update</button>
                                <button @click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Cancel</button>
                            </div>
                        </div>
                </form>
                <div class="card-body" v-else>
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <div class="col-md-10">
                                <h1>{{ title }}</h1>
                            </div>
                            <div class="ml-auto">
                                <div class="ml-auto">
                                    <a href="/questions" class="btn btn-outline-secondary">
                                        Back To All Questions
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="media">
                            <vote :model="question"  name="question" />
                            <div class="media-body">
                                <div v-html="bodyHtml"></div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="ml-auto">
                                            <a v-if="authorize('modify',question)" @click.prevent="edit" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <button v-if="authorize('deleteQuestion',question)" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <user-info :model="question" label="asked" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vote from './vote.vue';
import UserInfo from "./UserInfo";
export default {
    props: ['question'],
    components: {
        Vote,
        UserInfo
    },
    data() {
        return {
            title: this.question.title,
            body: this.question.body,
            bodyHtml: this.question.body_html,
            editing: false,
            id: this.question.id,
            beforeEditCashe: {}
        }
    },
    computed: {
        isInvalid () {
            return this.body.length < 10  || this.title.length < 10 ;
        },
        endPoint() {
            return `/questions/${this.id}`;
        }
    },
    methods: {
        edit (){
            this.beforeEditCashe =  {
                body: this.body,
                title: this.title
            };
            this.editing = true;
        },
        cancel () {
            this.body = this.beforeEditCashe.body;
            this.title = this.beforeEditCashe.title;
            this.editing = false;
        },
        update () {
            axios.put(this.endPoint, {
                body: this.body,
                title: this.title
            })
             .catch(({response}) => {
                 this.$toast.error(response.data.message,'Error', {
                     timeout: 3000,
                     position: 'bottomLeft'
                 });
             })
            .then(({data}) => {
                this.bodyHtml = data.body_html;
                this.$toast.success(data.message,'success', {
                    timeout: 3000,
                    position: 'bottomLeft'
                });
                this.editing = false;
            });
        },
        destroy () {
            this.$toast.question('Are you sure about that?',"Confirm",{
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>',  (instance, toast) => {

                        axios.delete(this.endPoint)
                            .then(({data}) => {
                               this.$toast.success(data.message,'Success',{timeout:3000,position:'bottomLeft'});
                            });
                        setTimeout(() =>{
                            window.location.href = "/questions";
                        },3000)
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ],

            });

        }

    }
}
</script>
