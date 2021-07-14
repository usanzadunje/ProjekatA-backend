<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>RESIZE | Landing Soon</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/img/resize/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/img/resize/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/img/resize/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('storage/img/resize/favicon.ico') }}" type="image/x-icon">
  </head>

  <body>
    <div class="logo">
      <img src="{{ asset('storage/img/resize/logo.png') }}" alt="RESIZE">
    </div>
    <div class="container">
        <section class="thin-shade">
          <div class="shade-text">
            We are in orbit!
          </div>
        </section>
      
        <div class="glitch-container">
          <div class="glitch" data-text="L A N D I N G">L A N D I N G</div>
          <div class="glitch" data-text="S O O N">S O O N</div>
      
        </div>
      
        <div>
          <div class="glitch glitch--small" data-text="hello@resize.rs">
            <a href="mailto:hello@resize.rs">hello@resize.rs</a>
          </div>
        </div>
    </div>
  </body>
</html>
