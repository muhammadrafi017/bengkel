@extends('layouts.app')

@section('content')
    <!--================ Start Home Banner Area =================-->
    <section class="home_banner_area">
        <div class="banner_inner">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="banner_content text-center">
                  <p class="text-uppercase">
                    Best College in Indonesia
                  </p>
                  <h2 class="text-uppercase mt-4 mb-5">
                   Go One Step Ahead
                  </h2>
                  <div>
                    <a href="#" class="primary-btn ml-sm-3 ml-0">see major</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================ End Home Banner Area =================-->
  
      <!--================ Start Feature Area =================-->
      <section class="feature_area section_gap_top">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="main_title">
                <h2 class="mb-3">A Acreditation</h2>
                <p>
                  Replenish man have thing gathering lights yielding shall you
                </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-6">
              <div class="single_feature">
                <div class="icon"><span class="flaticon-student"></span></div>
                <div class="desc">
                  <h4 class="mt-3 mb-2">Scholarship Facility</h4>
                  <p>
                    One make creepeth, man bearing theira firmament won't great
                    heaven
                  </p>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6">
              <div class="single_feature">
                <div class="icon"><span class="flaticon-book"></span></div>
                <div class="desc">
                  <h4 class="mt-3 mb-2">Professional Teacher</h4>
                  <p>
                    One make creepeth, man bearing theira firmament won't great
                    heaven
                  </p>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6">
              <div class="single_feature">
                <div class="icon"><span class="flaticon-earth"></span></div>
                <div class="desc">
                  <h4 class="mt-3 mb-2">Global Certification</h4>
                  <p>
                    One make creepeth, man bearing theira firmament won't great
                    heaven
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================ End Feature Area =================-->
  
      <!--================ Start Popular Courses Area =================-->
      <div class="popular_courses">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="main_title">
                <h2 class="mb-3">Avalaible Major</h2>
                <p>
                  Replenish man have thing gathering lights yielding shall you
                </p>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- single course -->
            <div class="col-lg-12">
              <div class="owl-carousel active_course">
                @foreach ($jurusan as $j)
                <div class="single_course">
                  <div class="course_head">
                    <img class="img-fluid" src="{{ asset('landing/img/courses/course-details.jpg')}}" alt="major_picture" />
                  </div>
                  <div class="course_content">
                    <span class="tag mb-4 d-inline-block">{{ $j->kategoriJurusan->nama }} - {{ $j->level }}</span>
                    <h4 class="mb-3">
                      <a href="{{ url('detail-jurusan/'.$j->id) }}"> {{ $j->nama }} </a>
                    </h4>
                    <p>
                      {{ substr($j->deskripsi, 0, 30) }} ...
                    </p>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--================ End Popular Courses Area =================-->
@endsection