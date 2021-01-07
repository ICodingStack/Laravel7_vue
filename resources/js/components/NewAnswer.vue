<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                    <form @submit.prevent="create">
                        <div class="form-group">
                            <textarea class="form-control"   name="body" id=""  v-model="body" rows="7" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit"  :disabled="isInvalid" class="btn btn-lg btn-outline-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ['questionId'],

    methods: {
        create (){
            axios.post(`/questions/${this.questionId}/answers`, {
                body: this.body
            })
            .catch(error => {
                this.$toast.warring(error.response.data.message,'Error', {
                    timeout:3000,
                    position:'bottomLeft'
                });
            })
            .then(({data}) => {
                this.$toast.success(data.message,'success', {
                    timeout:3000,
                    position:'bottomLeft'
                });
                this.body = '';
                this.$emit('created', data.answer);
            });
        }
    },

    data () {
        return {
            body: '',
        }
    },
    computed: {
        isInvalid() {
            return ! this.signedIn || this.body.length < 10 ;
        }
    }
}
</script>
