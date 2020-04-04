@extends('layouts.app')

@section('content')
<section class="course_details_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 course_details_left">
                <div class="main_image">
                    <img class="img-fluid" src="{{ asset('landing/img/courses/course-details.jpg')}}" alt="">
                </div>
                <div class="content_wrapper">
                    <i class="flaticon-eye"></i>
                    <h4 class="title">Deskripsi {{ $jurusan->nama }} </h4>
                    <div class="content">
                        {{ $jurusan->deskripsi }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection