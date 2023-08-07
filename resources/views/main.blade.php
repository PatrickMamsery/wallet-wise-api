<!DOCTYPE html>

<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta charset="utf-8">
    <title>Hype Interactive</title>
    <meta name="description" content="Build, what matters">
    <meta name="author" content="Hype interactive">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- stylesheets inclusion  --}}
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" href="">


    
</head>
<body>

        @include('shared.header')
            @yield('section')
        @include('shared.footer')

      {{-- javascript and jquery files inclusion --}}
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="/bootstrap/js/bootstrap.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
      <script src="/js/animations.js" type="text/javascript"></script>
      <script src="/js/main.js" type="text/javascript"></script>
      <script src="/js/live.js" type="text/javascript"></script> 
      <script src="https://kit.fontawesome.com/68b4c1056b.js" crossorigin="anonymous"></script> 
      
</body>
</html>


