@can('accept',$model)
    <a title="Mark This Answer As Best Answer"
       class=" {{$model->status}}  mt-2"
       onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit(); "
    >
        <i class="fas fa-check fa-2x"></i>
    </a>
    <form action="{{ route('answers.accept',$model->id) }}" id="accept-answer-{{ $model->id }}" method="post" style="display: none;">
        @csrf
    </form>
@else
    @if($model->is_best)
        <a title="The Question owner accepted this answer as best answer "
           class=" {{$model->status}}  mt-2"

        >
            <i class="fas fa-check fa-2x"></i>
        </a>
    @endif
@endcan
