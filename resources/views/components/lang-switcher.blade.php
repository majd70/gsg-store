<div class="dropdown">
    <button class="dropbtn">languge</button>
    <div class="dropdown-content">
        @foreach ($langs as $code=>$name)


      <a href="{{URL::current()}}?lang={{$code}}">
       {{$name}}
      </a>
      @endforeach
    </div>
  </div>
