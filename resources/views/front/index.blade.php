@extends("front.layouts.app")

@section("hero")
    <div class="d-flex flex-column w-100 min-h-lg-500px px-2 carousel carousel-custom slide" id="carousel_home" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="d-flex flex-wrap justify-content-end">
            <ol class="p-0 m-0 carousel-indicators carousel-indicators-dots">
                <li data-bs-target="#carousel_home" data-bs-slide-to="0" class="ms-1 active"></li>
                <li data-bs-target="#carousel_home" data-bs-slide-to="1" class="ms-1"></li>
                <li data-bs-target="#carousel_home" data-bs-slide-to="2" class="ms-1"></li>
                <li data-bs-target="#carousel_home" data-bs-slide-to="3" class="ms-1"></li>
            </ol>
        </div>
        <div class="carousel-inner pt-8 d-flex flex-wrap align-content-center text-center w-100">
            <!--begin::Item-->
            <div class="carousel-item active">
                <img src="/storage/slide/1.webp" alt="" class="img-fluid">
            </div>
            <!--end::Item-->

            <!--begin::Item-->
            <div class="carousel-item">
                <img src="/storage/slide/2.webp" alt="" class="img-fluid">
            </div>
            <!--end::Item-->

            <!--begin::Item-->
            <div class="carousel-item">
                <img src="/storage/slide/3.webp" alt="" class="img-fluid">
            </div>
            <!--end::Item-->

            <!--begin::Item-->
            <div class="carousel-item">
                <img src="/storage/slide/4.webp" alt="" class="img-fluid">
            </div>
            <!--end::Item-->
        </div>
    </div>
@endsection

@section("content")

@endsection

@section("script")
    <script src="/assets/js/custom/landing.js"></script>
@endsection
