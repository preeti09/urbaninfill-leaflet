<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.6/css/swiper.min.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css"
          integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clusterize.js/0.18.0/clusterize.min.css">
    <script
        src="https://cdn.tiny.cloud/1/zhx39j2ohsweb3po62947uwrnum0n1xhy3t5ospk0vkgobcs/tinymce/5/tinymce.min.js"></script>
    <script>tinymce.init({selector: 'textarea', height: 500});</script>
    <link rel="stylesheet" href="{{ url('/css/main.css') }}">
    <link rel="stylesheet" href="{{url('/css/loading-bar.css')}}">
    @yield('head')
    <title>@yield('title')</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-fixed-top navbar-dark">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li>
                <a class="nav-link" href="/">LotHub</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li>
                <a class="nav-link" id="menu1" href="/">Historically Platted Lots</a>
            </li>
            <li>
                <a class="nav-link " id="menu2" href="/VacantProperties">Vacant Lots</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="menu3" href="/location">Address Search </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="menu4" href="/person">Person Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="menu4" href="/hpl2">hpl2</a>
            </li>
            <li class="nav-item">
                <a href="/savedproperties" target="_blank" id="menu5" class="nav-link">Saved Properties</a>
            </li>
            <li class="nav-item">
                <a href="/logout" class="nav-link">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<!--
<div style="
        background-color: red;
        color: white;
        padding: 1px 5px;
        text-align: center;">
    <h1 style="color:white"
    > PLEASE PAY THE DUE AMOUNT</h1>
</div>
-->
<div id="loading"></div>
<div id="isLoaded">
    <div class="pt-3">
        <div class="row">
            <div class="col" style="justify-content: center">
                <img src="{{URL::asset('/Img/Lot_Hub_Banner.png')}}" alt="" class="mx-auto d-block">
                <h1 class="center" >Learn How to Find Deals with This Lothub Tutorial Video </h1>
                <h1 class="center"> <a  href="https://www.youtube.com/embed/dqcdh-W53Ag" target="_blank">Click Here To Watch Video Tutorial.</a> </h1>

                <!--
                <div  style="width: 700px;" class="mx-auto d-block">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe  src="https://www.youtube.com/embed/dqcdh-W53Ag" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                -->
                <br>
                <h1 class="center">Ready to Find Hot Property Deals Nationwide? Enter the Desired Zip-Code Below</h1>

                <h4 class="center"><small> <strong>You have {{$Rcout}} Historic Lot Searches Left. Search Limit will refresh in {{$timeExceed}} </strong></small></h4>

                <br>
                <label class="form-text text-muted center" for="searchByPropForm">Enter the Zip-Code Below to Find Historically Platted Lots</label>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <div class="input-group  mb-3 search search-reduce" id="searchByPropForm">
                        <input class="form-control" id="search" name="address" type="text" placeholder="By Property"  onFocus="geolocate()" required="true" value="" aria-describedby="searchByProperty"/>
                        <div class="input-group-append">
                            <input class="btn btn-primary" type="button" value="Search" id="searchByProperty">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="searchloading">
        <div
            class="label-center"
            id="ldBar"
            style="width:30%;height:30%;margin:auto"
            data-value="0"
            data-preset="bubble">
        </div>
    </div>
    <div id="issearchdone">
    <div class="row">
        <div class="col-md-6">


            <div class="map" id="map"></div>



            <div class="row">
                <div class="col-md-6 pd-col brd" id="houseDiv">
                    <h2 class="ageDemo mt-30">Housing Inventory</h2>
                    <div class="chart_bar" style="position: relative; margin:0 auto;width:80%; height:150px;" >
                        <div id="chart-1" ></div>
                    </div>
                </div>

                <div class="col-md-6 brd" id="eduDiv">

                    <img src="Img/icon-stat.png" alt="">
                    <h2 class="ageDemo mt-30">Highest education<br>level attained</h2>
                    <h3>Info</h3>
                    <p>The highest education level attained is based on the percentage of eligible graduates within the given population who have achieved the level of education listed.</p>
                    <div class="gap20"></div>

                    <div class="list-row">
                        <span class="list-title">No HS</span>
                        <span class="list-price" id="noHS">  </span>
                    </div>
                    <div class="list-row">
                        <span class="list-title">Some HS</span>
                        <span class="list-price" id="someHS"></span>
                    </div>
                    <div class="list-row">
                        <span class="list-title">HS Grad</span>
                        <span class="list-price" id="hsGrad"></span>
                    </div>
                    <div class="list-row">
                        <span class="list-title">Some College</span>
                        <span class="list-price" id="someCollege"></span>
                    </div>
                    <div class="list-row">
                        <span class="list-title">Associate Degree</span>
                        <span class="list-price" id="associate"></span>
                    </div>
                    <div class="list-row">
                        <span class="list-title">Bachelor's Degreee</span>
                        <span class="list-price" id="bachlor"></span>
                    </div>
                    <div class="list-row">
                        <span class="list-title">Graduate Degreee</span>
                        <span class="list-price" id="graduate"></span>
                    </div>


                </div>
            </div>
            <div class="col-md-12 brd" id="incomeDiv">
                <h2 class="ageDemo mt-30">Income by Households</h2>
                <div class="chart_bar" style="position: relative;height:150px;" >
                    <canvas id="myChart"></canvas>
                </div>
            </div>

        </div>


        <div class="col-md-6 mt-30" id="poiContent">
            <div class="alert alert-dark" role="alert" id="searchCount">
                Count :
            </div>
            <div class="input-group mb-3"  style="padding-right: 10px;">
                <input type="email" id="emailaddress" class=" form-control" placeholder="Enter Email Address" aria-label="Enter Email Address aria-describedby="sendEmail">
                <div class="input-group-append">
                    <button type="button" id="sendEmail" class="btn btn-secondary mb-1"><i class="far fa-envelope"></i></button>
                </div>
            </div>
            <small id="emailHelp" class="form-text text-muted"></small>

            <div class="row">
                <div class="col">
                    <div class="next-slide " id="next-slide"> <button type="button" class="btn btn-outline-dark" style="width: 100%;"><i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 20px;"></i></button></div>
                </div>
                <div class="col">
                    <div class="prev-slide " id="prev-slide"> <button type="button" class="btn btn-outline-dark" style="width: 100%;"><i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 20px;"></i></button></div>
                </div>
            </div>

            <br>

            <div class="swiper-container">


                <div class="swiper-wrapper">



                    <!-- Add Arrows -->
                    <!-- Add Pagination -->

                </div>
                <!--<div class="swiper-button-next"><img src="images/icons/right.png" alt="right"></div>
                <div class="swiper-button-prev"><img src="images/icons/left.png" alt="left"></div>-->
                <div class="swiper-scrollbar"></div>




            </div>
        </div>
    </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="myModal"  role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Property info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-6">
                                <img id="ModalImg" width="100%" height="400" src="" alt="">
                            </div>
                            <div class="col-6">
                                <div class=" map" id="Modalmap" style="width: 100%;height: 100%">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="SaveLink" class="btn btn-primary">Save Property</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="noteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>LotHub is Currently Undergoing Maintenance. Please Expect Temporary Bugs That Will Disappear Within
                    The Hour.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.6/js/swiper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clusterize.js/0.18.0/clusterize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"
        integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp"
        crossorigin="anonymous"></script>
<script src="{{ url('/js/bootstrap-notify.min.js') }}"></script>
<script src="{{ url('/js/cookies.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="module" src=" {{ url('/js/siema.js') }}"></script>
<script src="{{url('/js/loading-bar.js')}}"></script>
<script src=" {{ url('/js/test_demo.js') }}"></script>
<script src=" {{ url('/js/MapLibrary.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.6/js/swiper.min.js"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChy0iFCguYHXfzxP_G1L1knHzvImm8VcQ&libraries=places,drawing&callback=initAutocomplete"></script>
<script src=" {{ url('/js/notify.js') }}"></script>
@yield('script')

<script type="text/javascript">
    $(window).on('load', function () {
        setTimeout(function () {
            if (!Cookies.get('modalShown')) {
                $("#noteModal").modal('show');
                Cookies.set('modalShown', true);
            }

        }, 30);
    })

    /* $(window).on('load',function(){
         $('#noteModal').modal('show');
     });*/
</script>
</body>
</html>
