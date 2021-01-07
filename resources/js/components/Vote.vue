<template>
    <div class="d-flex flex-column vote-controls">
        <a @click.prevent="voteUp" :title="title('up')"
           class="vote-up"  :class="classes">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>
        <span class="votes_count">{{ count }}</span>

        <a @click.prevent="voteDown" :title="title('down')"
           class="vote-down" :class="classes">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>

        <favorite v-if="name === 'question'"   :question="model" />
        <accept v-else :answer="model" />

    </div>

</template>

<script>
import Favorite from './Favorite';
import Accept from './Accept';

export default {
    props: ['name', 'model'],
    computed: {
        classes () {
            return this.signedIn ? '' : 'off';
        },
        endPoint () {
            return `/${this.name}s/${this.id}/vote`;
        }
    },
    components: {
        Favorite,
        Accept
    },
    data () {
        return {
         count: this.model.votes_count || 0,
            id: this.model.id
        };
    },

    methods: {
        title (voteType) {
            let titles = {
                up: `This ${this.name} is useful`,
                down: `This ${this.name} is not useful`
            };
            return titles[voteType];
        },
        voteUp () {
            this._vote(1);
        },
        voteDown () {
            this._vote(-1);
        },
        _vote (vote) {
            if(! this.signedIn){
                this.$toast.warning(`please log in to vote the ${this.name} ` , 'warning', {
                    timeout:3000,
                    position:'bottomLeft'
                });
                return;
            }
            axios.post(this.endPoint, {vote})
            .then(res => {
               this.$toast.success(res.data.message , 'success', {
                    timeout:3000,
                    position:'bottomLeft'
                });
               this.count =res.data.votesCount;
            });
        }
    }
}
</script>
