var canvas = document.querySelector('canvas');
var WWidth = window.innerWidth;
var WHeight = window.innerHeight;

canvas.width = WWidth;
canvas.height = WHeight;
var c = canvas.getContext('2d');
var mouseX = 0;
var mouseY = 0;

const radius = 2;
var dotArray = [];
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

function dot(startPosX, startPosY, radius, startVelocityX, startVelocityY) {
  this.posX = startPosX;
  this.posY = startPosY;
  this.radius = radius;
  this.velocityX = startVelocityX;
  this.velocityY = startVelocityY;

  this.drawSelf = function() {
    c.beginPath();
    c.arc(this.posX, this.posY, this.radius, 0, Math.PI * 2, true);
    c.fillStyle = "white";
    c.fill();
    c.stroke();
  }

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

function updateMousePos(event) {
  mouseX = event.clientX;
  mouseY = event.clientY;
  console.log("mouseX: ",mouseX," mouseY: ", mouseY);
}

function animate() {
  requestAnimationFrame(animate);

  c.clearRect(0,0, WWidth, WHeight);
  for (var i = 0; i < dotArray.length; i++) {
    dotArray[i].update();
}


  // c.clearRect(0,0, WWidth, WHeight);
  // c.beginPath();
  // c.arc(pos_X, pos_Y, radius, 0, Math.PI * 2, true);
  // c.fillStyle = "black";
  // c.fill();
  // c.stroke();
  //
  // if (pos_X + radius >= WWidth ||  pos_X - radius <= 0)
  // {
  //   velocity_X = -velocity_X;
  // }
  //
  // if (pos_Y + radius >= WHeight ||  pos_Y - radius <= 0)
  // {
  //   velocity_Y = -velocity_Y;
  // }
  //
  // pos_X += velocity_X;
  // pos_Y += velocity_Y;
}

animate();
