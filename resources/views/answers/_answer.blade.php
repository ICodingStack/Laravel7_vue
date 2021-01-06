<answer :answer=" {{$answer}} " inline-template>
    <div class="media post">
        <vote  :model="{{ $answer }}" name="answer" />
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea class="form-control" v-model="body" rows="10"  required></textarea>
                </div>
                <button  class="btn btn-sm btn-outline-primary" :disabled="isInvalid">Update</button>
                <button @click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Cancel</button>
            </form>
            <div v-else>
               <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            @can('update',$answer)
                                <a @click.prevent="edit" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>
                            @endcan
                            @can('delete',$answer)
                                    <button @click="destroy" class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </button>
                            @endcan
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">

                        <user-info :model="{{$answer}}" label="answered" />
                    </div>
                </div>
            </div>

        </div>
    </div>

</answer>
