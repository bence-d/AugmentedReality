/* This script is made for tagging parts on the image.*/
/* This script is working with multiple eventHandlers of the editorDiv */

import { updateTagList, GetSelectedTagID } from "./listHandler.js";
//import { updateFields } from "./dataEditor.js";

var tagList = document.getElementById("tagList");
var editor = document.getElementById("editor");
var editorDiv = document.getElementById("editorDiv");
var cordX = document.getElementById("cordX");
var cordY = document.getElementById("cordY");
var mousePos = [0,0];
var tags = [];
var highlighted = null;
var lastTag;

const TAG_RADIUS = 10;
const MIN_DISTANCE = 25;

// Update the tag array that's inside this script
function updateTagArray() {
  //console.log("--- UPDATE TAG ARRAY ---");
  var tagHolder = document.getElementById("tags");
  tagHolder = tagHolder.childNodes;
  tags = [];

  for (var i = 0; i < tagHolder.length; i++) {
    if (tagHolder[i].className == "tag")
    {
      //console.log("found tag to add...");
      var tagToAdd = {};

      tagToAdd['id'] = tagHolder[i].id;
      tagToAdd['title'] = "";
      tagToAdd['description'] = "";
      tagToAdd['X'] = tagHolder[i].style['left'];
      tagToAdd['Y'] = tagHolder[i].style['top'];

      //console.log("object created from tag:");
      //console.log(tagToAdd);
      tags.push(tagToAdd);
    }
  }

  //console.log(tags);

}

function getDelta(x, y) {
  if (x > y) {
    return x - y;
  }
  return y - x;
}

// Checks if there are any tags close to the mouse
function checkDistance(event) {
  mousePos = getMousePosition(event);
  updateTagArray();

  if (tags.length != 0)
  {
    for (var i = 0; i < tags.length; i++) {
      if ((getDelta(tags[i].offsetTop + TAG_RADIUS, mousePos[1]) < MIN_DISTANCE) && (getDelta(tags[i].offsetLeft + TAG_RADIUS, mousePos[0]) < MIN_DISTANCE))
      {
        return false;
      }
    }
  }

  return true;
}

// I made this function because the tagHolder element has some other children than only the tags as well
function getNumberOfTags() {
  var tagHolder = document.getElementById("tags");
  tagHolder = tagHolder.childNodes;
  var result = 0;

  for (var i = 0; i < tagHolder.length; i++) {
    if (tagHolder[i].className == "tag") {
      result++;
    }
  }

  return result;
}

// Places a tag on the mouse's current poisition
function createTag() {
  var tagHolder = document.getElementById("tags");
  var newDiv = document.createElement("div");
  newDiv.className = ("tag");
  newDiv.id = "tag" + (getNumberOfTags() + 1);
  newDiv.style.top = "" + (mousePos[1] - 108) + "px";
  newDiv.style.left = "" + (mousePos[0] - 10) + "px";

  //console.log("New tag added: ", newDiv);
  tagHolder.appendChild(newDiv);
}

editorDiv.addEventListener("click", function(event) {
  if (checkDistance(event)) {
    createTag();
    updateTagArray();
    updateTagList();
  }
})

// Updating X/Y Cord Display
editorDiv.addEventListener("mousemove", function(event) {
  var cords = getMousePosition(event);
  cordX.innerHTML = "X: " + cords[0];
  cordY.innerHTML = "Y: " + (cords[1] - 98);
});

// Getting Mouse Position
function getMousePosition(event) {
    var x = event.pageX - editor.offsetLeft;
    var y = event.pageY - editor.offsetTop;
    return [x,y];
}

// Highlighting the currently selected tag
tagList.addEventListener("change", highLightTag);

function highLightTag() {
  var IDOfTag = GetSelectedTagID();

  if (lastTag)
  {
    lastTag.style['background-color'] = 'black';
  }

  document.getElementById(IDOfTag).style['background-color'] = 'red';
  lastTag = document.getElementById(IDOfTag);
}

function getTagArray() {
  //console.log("updating tag array...");
  updateTagArray();
  //console.log("tagging.js: returning tags: ");
  //console.log(tags);
  //console.log("hopping back to listHandler.js...");
  return tags;
}

function generateTagsFromArray() {
  tags = JSON.parse(document.getElementById('tagData').value);
  //console.log("generateTagsfromarray: json of tagdata:");
  //console.log(tags);
  var tagHolder = document.getElementById("tags");

  for (var i = 0; i < tags.length; i++)
  {
    var newDiv = document.createElement("div");
    newDiv.className = "tag";
    newDiv.id = tags[i].id;
    newDiv.style.top = tags[i].Y;
    newDiv.style.left = tags[i].X;

    tagHolder.appendChild(newDiv);
  }
}

export { getTagArray, generateTagsFromArray };