<!-- frontend -->
<div class="list-card">
  <div class="row">
    <div class="col-md-12">
      <p class="lead">
        <span class="label label-success pull-left">{{$post->id}}</span>
        <span class="label label-default pull-right">Posted at - {{$post->created_at}}</span>
      </p>
    </div>
    <div class="col-md-12">
      <p>
        <h6 style="font-weight:bold; color: #000">{{$post->post_text}}</h6>
      </p>
    </div>
    <div class="col-md-12">eventPost
      <p>
        <span>
            @if(!is_null($post->post_image))
              <img width="100%" height="300px" src={{ route('eventPost', [$post->post_image]) }} alt="...">
            @endif
        </span>
      </p>
    </div>
  </div>
</div> <!-- card -->