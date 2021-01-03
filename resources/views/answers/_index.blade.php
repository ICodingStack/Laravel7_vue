@if($answerCount > 0)
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{ $answerCount . " " . str_plural('Answer',$answerCount) }}</h2>
                </div>
                <hr>
                @include('layouts._messages')

                @foreach($answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a title="This Answer is useful"
                               class="vote-up {{ Auth::guest() ? 'off' : '' }} "
                               onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{ $answer->id }}').submit(); "
                            >
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <form action="/answers/{{ $answer->id }}/vote" id="up-vote-answer-{{ $answer->id }}" method="post" style="display: none;">
                                @csrf
                                <input type="hidden" name="vote" value="1">
                            </form>
                            <span class="votes_count">{{ $answer->votes_count }}</span>
                            <a title="This Answer is not useful"
                               class="vote-down {{ Auth::guest() ? 'off' : '' }}"
                               onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{ $answer->id }}').submit(); "
                            >
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            <form action="/answers/{{ $answer->id }}/vote" id="down-vote-answer-{{ $answer->id }}" method="post" style="display: none;">
                                @csrf
                                <input type="hidden" name="vote" value="-1">
                            </form>
{{--                            @include('shared._vote',['model'=>$answer])--}}
                        </div>
                        <div class="media-body">
                            {!! $answer->body_html !!}
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        @can('update',$answer)
                                            <a href="{{route('questions.answers.edit',[$question->id, $answer->id])}}" class="btn btn-sm btn-outline-primary">
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
                                    @include('shared._auther',[
                                        'model' =>$answer,
                                        'label' =>'answered'
                                        ])
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
