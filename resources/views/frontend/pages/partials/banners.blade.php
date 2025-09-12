{{-- Banners slideshow --}}
@if($banners->where('type','image')->count())
<div class="mb-6">
  <div class="swiper mySwiper rounded-xl overflow-hidden relative">
    <div class="swiper-wrapper">
      @foreach($banners->where('type','image') as $banner)
        <div class="swiper-slide">
          <a href="{{ $banner->url ?? '#' }}">
            <img src="{{ $banner->image_url }}" 
                 alt="{{ $banner->title }}">
          </a>
        </div>
      @endforeach
    </div>
    <div class="swiper-pagination"></div>
    <!-- <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div> -->
  </div>
</div>
@endif