var Resumable = require('./resumable');
var EXIF = require('exif-js');

(function(){

  var showFormattedEXIFData = function(exifData){
    console.log(exifData)

    var ul = document.createElement('ul');

    for (let eachData in exifData) {
      if (exifData.hasOwnProperty(eachData)) {
        //console.log(eachData + " -> " + exifData[eachData]);
        let li = document.createElement('li');
        li.addEventListener('click', this, () => {console.log('sad')});
        li.appendChild(document.createTextNode(eachData + " -> " + exifData[eachData]))
        ul.appendChild(li);
      }
    }

    document.getElementById('exifData').appendChild(ul);
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
        var exifData = EXIF.getAllTags(this);
        showFormattedEXIFData(exifData)
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