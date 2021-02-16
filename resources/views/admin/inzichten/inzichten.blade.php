@extends('layouts.template')



@section('sidebar')


    <div class="container-fluid">
        <div class="row row-offcanvas row-offcanvas-left">
            <div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
                <div class="sidebar-nav">
                    <br>
                    <br>

                    <button id="clearAll" class="btn btn-outline-info clear">clear</button>
                    <br>
                    <br>
                    <div id="QV06" class="qvobject3 qvplaceholder3 "></div>
                    <div id="QV05" class="qvobject3 qvplaceholder3 "></div>




                </div>
                <!--/.well -->
            </div>
@endsection
@section('main')



<div id="body">



    <h1>Inzichten</h1>
    <hr>


        <h2>Aanwezigheid</h2>
    <div class="row">
        <div id="QV03" class="qvobject qvplaceholder "></div>
    </div>
    <hr>
    <h2>Stock</h2>
    <div class="row">
        <div id="QV04" class="qvobject2 qvplaceholder2 "></div>

    </div>
    <hr>
    <h2>Gescande nummerplaten</h2>
    <div class="row">
        <div id="QV07" class="qvobject2 qvplaceholder2 "></div>

    </div>
</div>
@endsection
