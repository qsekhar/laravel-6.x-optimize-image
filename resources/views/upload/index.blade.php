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

    <script src="{{ mix('/js/resumable.js') }}"></script>
    <script>
    
    (function(){

      var r = new Resumable({
        target: "{{url('/resumable')}}",
        chunkSize: 1*1024*1024,
        testChunks:false,
        simultaneousUploads:1,
        headers:{
            'X-CSRF-Token' :"{{ csrf_token() }}"
        },
        query:{
            _token : "{{ csrf_token() }}"
        }
      });

      r.assignBrowse(document.getElementById('browseButton'));

      r.on('fileSuccess', function(file){
          console.debug('fileSuccess',file);
        });
      r.on('fileProgress', function(file){
          console.debug('fileProgress', file);
        });
      r.on('fileAdded', function(file, event){
          r.upload();
          console.debug('fileAdded', event);
        });
      r.on('filesAdded', function(array){
          r.upload();
          console.debug('filesAdded', array);
        });
      r.on('fileRetry', function(file){
          console.debug('fileRetry', file);
        });
      r.on('fileError', function(file, message){
          console.debug('fileError', file, message);
        });
      r.on('uploadStart', function(){
          console.debug('uploadStart');
        });
      r.on('complete', function(){
          console.debug('complete');
        });
      r.on('progress', function(){
          console.debug('progress');
        });
      r.on('error', function(message, file){
          console.debug('error', message, file);
        });
      r.on('pause', function(){
          console.debug('pause');
        });
      r.on('cancel', function(){
          console.debug('cancel');
      });

    })();
    
    
    </script>
    </body>
</html>




