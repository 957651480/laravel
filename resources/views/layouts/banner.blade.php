<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach($banners as $banner)
            <li data-target="#carouselExampleCaptions" data-slide-to="{{$loop->index}}"
                @if($loop->first) class="active" @endif
            ></li>
        @endforeach
    </ol>
    <div class="carousel-inner">
        @foreach($banners as $banner)
            <div class="carousel-item @if($loop->first) active @endif">
                <img src="{{$banner->image->url}}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>{{$banner->title}}</h5>
                    <p>{{$banner->desc}}</p>
                </div>
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
