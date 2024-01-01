'use strict';

//init vars and elements
const video = document.getElementById('video');
var canvas = document.getElementById('canvas');
var preview = document.getElementById('preview');
const snap = document.getElementById("snap");
const post = document.getElementById("submit-post");
const upload = document.getElementById("fileUpload");
const errorMsgElement = document.querySelector('span#errorMsg');
const clear = document.getElementById("clear");
const webcon = document.getElementById("webcon");

//custom input size
var myWidth = 640;
var myHeight = 480;

//video stream conditions
const constraints = {
  audio: false,
  video: {
    width: myWidth, height: myHeight
  }
};

// Access webcam
async function init() {
  try {
    const stream = await navigator.mediaDevices.getUserMedia(constraints);
    handleSuccess(stream);
  } catch (e) {
    errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
  }
}

// Success
function handleSuccess(stream) {
  video.srcObject = stream;
}

// Load init
init();

// Draw image. canvas init
var cancontext = canvas.getContext('2d');
var precontext = preview.getContext('2d');

// capture image
snap.addEventListener("click", function() {
  cancontext.save();
  cancontext.scale(-1, 1);
  cancontext.drawImage(video, 0, 0, myWidth * -1, myHeight);
  cancontext.restore();
  cancontext.drawImage(preview, 0, 0);
  canvas.hidden = false;
  post.hidden = false;
});

//post image
post.addEventListener("click", function() {
  const form = document.createElement('form');
  form.method = "POST";
  form.action = 'includes/postHandler.php?action=create';

  const hiddenField = document.createElement('input');
  hiddenField.type = 'hidden';
  hiddenField.name = "postImage";
  hiddenField.value = canvas.toDataURL();

  form.appendChild(hiddenField);

  document.body.appendChild(form);
  form.submit();
});


//upload image

function readImage() {
  if ( this.files && this.files[0] ) {
      var FR = new FileReader();
      FR.onload = function(e) {
         var img = new Image();
         img.addEventListener("load", function() {
           paint(img);
         });
         img.src = e.target.result;
      };       
      FR.readAsDataURL( this.files[0] );
  }
}

//draw to canvas when an image has been uploded
upload.addEventListener("change", readImage, false);

//depreciated custom canvas drawing
function paint(imgin) {
  precontext.drawImage(imgin, 0, 0, myWidth, myHeight)
}

//default hide post button
post.hidden = true;
canvas.hidden = true;

// clear preview canvas
clear.addEventListener("click", function() {
  precontext.clearRect(0, 0, canvas.width, canvas.height);
});

//init webcam sizes
video.height = myHeight;
video.width = myWidth;
preview.height = myHeight;
preview.width = myWidth;
canvas.height = myHeight;
canvas.width = myWidth;
webcon.height = myHeight;
webcon.width = myWidth;
video.style['background-color'] = "white";