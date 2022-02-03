<!-- begin::Aside Brand -->
<div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
    <div class="kt-aside__brand-logo">
        <a href="{{route('home')}}">
            @if(session()->has('darkMode'))
            <img alt="Logo" src="{{url('/media')}}/site/dark.svg"/>
            @else
                <img alt="Logo" src="{{url('/media')}}/site/wakeb.png"/>
            @endif
        </a>
    </div>
    <div class="kt-aside__brand-tools">
        <button class="kt-aside__brand-aside-toggler kt-aside__brand-aside-toggler--left" id="kt_aside_toggler">
            <span></span></button>
    </div>
</div>

<!-- end:: Aside Brand -->
