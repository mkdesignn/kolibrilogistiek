<!DOCTYPE html>
<html lang="{{ Lang::locale() }}">
    <head>
        <title>@if(isset($page_title)){{ $page_title . ' | ' }}@endif{{ SYSTEM_NAME }}</title>   
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf_token" content="{{ csrf_token() }}"/>
        <meta name="application-name" content="{{ SYSTEM_NAME }}">
        <meta name="version" content="{{ GIT }}"/>
        {!! favicons() !!}
        <link rel="stylesheet" href="{{ protocol_relative_asset(enviroment_based_elixir('css/all.css')) }}"/>
        <!--[if lt IE 9]>
            <script src="{{ protocol_relative_asset('js/backward_compatibility.js') }}"></script>
        <![endif]-->
    </head>
    <body>
    @include('partials.navbar')
    <div class="container-fluid body-hidden">{!! (isset($baseContent) ? $baseContent : '') !!}
@yield('content')
    </div>
    <script>
var config = JSON.parse(`{!! $javascriptConfig !!}`);
    </script>
@if (admin())         
    <script src="{{ protocol_relative_asset(enviroment_based_elixir('js/admin.js')) }}"></script>
@else
    <script src="{{ protocol_relative_asset(enviroment_based_elixir('js/all.js')) }}"></script>    
@endif        
@yield('footer')  
    </body>
</html>