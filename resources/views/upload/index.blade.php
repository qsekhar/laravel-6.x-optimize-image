<html>
    <head>
      <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        
    <form method="post" action="{{url('/upload')}}" enctype="multipart/form-data">
      {{ csrf_field() }}
      ...
      <div class="form-group">
          <label for="author">Cover:</label>
          <input type="file" class="form-control" name="photo"/>
          <button type="submit">Upload</button>
      </div>
      ...


      <a href="#" id="browseButton">Select files</a>

    </form>

    <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>




