@extends('layouts.estate')
@section('content')
<main>
    <!-- breadcrum -->
    <div class="breadcrum">
        <div class="container">
            <h1 class="breadcrumTittle">success</h1>
        </div>
    </div>
    <!-- Bredacrum Over -->
    @if($status==true)

    Payment success
    @endif
    @if($status==false)
    payment fail
    @endif
</main>
@endsection