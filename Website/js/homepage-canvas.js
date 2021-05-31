/* Variables & getting elements*/
var canvas = document.querySelector('canvas');
var WWidth = window.innerWidth;
var WHeight = window.innerHeight;

canvas.width = WWidth;
canvas.height = WHeight;
var c = canvas.getContext('2d');
var mouseX = 0;
var mouseY = 0;

const radius = 2; // radius of the dots
var dotArray = []; // the array that olds the dot elements

/* creating dots */
for (var i = 0; i < 50; i++) {
  var startPosX = Math.random() * WWidth;
  var startPosY = Math.random() * WHeight;
  var startVelocityX = 0.2;
  var startVelocityY = 0.2;

  if (Math.random() >= 0.5) {
    startVelocityX = -startVelocityX;
  }

  if (Math.random() >= 0.5) {
    startVelocityY = -startVelocityY;
  }

  dotArray.push(new dot(startPosX, startPosY, radius, startVelocityX, startVelocityY));
}

function difference(x,y) {
  if (x > y) {
    return (x - y);
  }
  else {
    return (y - x);
  }
}

/* dot element */
function dot(startPosX, startPosY, radius, startVelocityX, startVelocityY) {
  this.posX = startPosX;
  this.posY = startPosY;
  this.radius = radius;
  this.velocityX = startVelocityX;
  this.velocityY = startVelocityY;

  /* function for drawing the current element (because the canvas will be cleared each frame) */
  this.drawSelf = function() {
    c.beginPath();
    c.arc(this.posX, this.posY, this.radius, 0, Math.PI * 2, true);
    c.fillStyle = "white";
    c.fill();
    c.stroke();
  }

  /* drawing lines between the dots */
  this.drawConnections = function() {
    for (var i = 0; i < dotArray.length; i++) {
      if (difference(this.posX, dotArray[i].posX) < 150 && difference(this.posY, dotArray[i].posY) < 150) {
        c.beginPath();
        c.moveTo(this.posX, this.posY);
        c.strokeStyle = '#ffffff';
        c.lineTo(dotArray[i].posX, dotArray[i].posY);
        c.closePath();
        c.stroke();
      }

      if (difference(this.posX, mouseX) < 150 && difference(this.posY, mouseY) < 150) {
        c.beginPath();
        c.moveTo(this.posX, this.posY);
        c.strokeStyle = '#ffffff';
        c.lineTo(mouseX, mouseY);
        c.closePath();
        c.stroke();
      }
    }
  }

  /* updating the dot's position */
  this.update = function() {
    if (this.posX + this.radius >= WWidth ||  this.posX - this.radius <= 0)
    {
      this.velocityX = -(this.velocityX);
    }

    if (this.posY + this.radius >= WHeight ||  this.posY - this.radius <= 0)
    {
      this.velocityY = -(this.velocityY);
    }

    this.posX += this.velocityX;
    this.posY += this.velocityY;

    this.drawSelf();
    this.drawConnections();
  }
}


/* updating the variables holding the mouse's position */
function updateMousePos(event) {
  mouseX = event.clientX;
  mouseY = event.clientY;
  console.log("mouseX: ",mouseX," mouseY: ", mouseY);
}

function animate() {
  requestAnimationFrame(animate); // calling this method each frame

  c.clearRect(0,0, WWidth, WHeight); // clearing the canvas

  /* iterating through all of the dots and updating them */
  for (var i = 0; i < dotArray.length; i++) {
    dotArray[i].update();
  }
}

animate(); // starting the whole animation process
