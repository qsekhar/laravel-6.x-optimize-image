var Resumable = require('./resumable');
var EXIF = require('exif-js');

(function(){

  var base64ToArrayBuffer = function (file) {
    return new Promise(function (resolve, reject) {
      var reader = new FileReader();
      reader.onload = function() {
        resolve(new Uint8Array(reader.result));
      }
      reader.readAsArrayBuffer(file);
    });
  }
      
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
      //r.upload();
      EXIF.getData(file.file, function() {
        var make = EXIF.getTag(this, "Make");
        var model = EXIF.getTag(this, "Model");

        var exifData = EXIF.getAllTags(this);
        console.log(exifData)
      });
      console.debug('fileAdded', event);
    });
  r.on('filesAdded', function(array){
      //r.upload();
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