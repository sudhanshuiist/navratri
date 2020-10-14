var video = document.getElementById("videoElement");
var startVideo = document.getElementById("startRecording");
var stopVideo = document.getElementById("stopRecording");
stopVideo.hidden = true;
var retakeVideo = document.getElementById("retake");
retakeVideo.hidden = true;
var share_to_facebook = document.getElementById("sharefb");
var downloadVideo = document.getElementById("downloadVideo");

var mediaRecorder;
var recordedChunks = [];

function controlRecording(key) {
  if (key == 0) {
    
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      
      navigator.mediaDevices.getUserMedia({ audio:true, video: {facingMode:"user"} }).then(function (stream) {
        video.srcObject = stream;
        video.play();

        startVideo.hidden = true;
        stopVideo.hidden = false;
        
        mediaRecorder = new MediaRecorder(stream);

        mediaRecorder.start();
        mediaRecorder.ondataavailable = function(event){
          if (event.data.size > 0) {
            recordedChunks.push(event.data);
          } else {
            console.log(event);
          }
        };

      }).catch(function (error) {
        alert("Something went wrong: => "+error);
      });
    } else {
      alert("Can Not access camera");
    }
  } else {

    video.pause();
    startVideo.hidden = true;
    stopVideo.hidden = true;
    retakeVideo.hidden = false;

    var stream = video.srcObject;
    stream.getTracks().forEach(function(track) {
      track.stop();
    });

    mediaRecorder.onstop = function(){
      var blob = new Blob(recordedChunks, {'type': 'video/mp4;'});

      recordedChunks = [];
  
      var url = URL.createObjectURL(blob);
      downloadVideo.href = url;
      downloadVideo.download = "video.mp4";
      downloadVideo.click();
      window.URL.revokeObjectURL(url);
    }

  }

}

function retake() {
  video.srcObject = null;
  startVideo.hidden = false;
  stopVideo.hidden = true;
  retakeVideo.hidden = true;
}
