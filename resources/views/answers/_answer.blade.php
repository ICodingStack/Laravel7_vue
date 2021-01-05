<answer :answer=" {{$answer}} " inline-template>
    <div class="media post">
        @include('shared._vote' , ['model' =>$answer])
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
                                <form class="form-delete" action="{{ route('questions.answers.destroy' , [$question->id, $answer->id] ) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are You Sure?')">
                                        Delete
                                    </button>
                                </form>
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
