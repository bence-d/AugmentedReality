/* This script updates the Data Manager's list of the tags on the image. */
/* This script is used in tagging.js after creating an image tag */
/* This script is used in dataEditor.js for retrieving the currently selected Tag */

import { getTagArray, generateTagsFromArray } from './tagging.js';

var field_name = document.getElementById("field_name");
var field_description = document.getElementById("field_description");
var button_submit = document.getElementById("button_submit");
var tagList = document.getElementById('tagList');
var tags = [];

// Update the select element in the index.html
function updateTagList() {
    console.log("entered updatetaglist...");
    // Collect the children of the tagList
    var tagList = document.getElementById("tagList");
    tagList = tagList.childNodes;
    var tagOptions = [];
  
    for (var i = 0; i < tagList.length; i++) {
      if (tagList[i].className == "tag_option") {
        tagOptions.push(tagList[i]);
      }
    }
    
    console.log("tagOPtions:");
    console.log(tagOptions);
    
    tags = getTagArray();
    
    // Check and eventually add the missing tags to the list
    for (var i = 0; i < tags.length; i++) {
      //console.log("entered for loop ...");
      var alreadyIncluded = false;
  
      // check if the give tag is in the list
      for (var o = 0; o < tagList.length; o++) {
        if (tagList[o].innerHTML == tags[i].id) {
          alreadyIncluded = true;
          //console.log("already included: ");
          //console.log("tagList innerHTML: " + taglist[o].innerHTML);
          //console.log("tag id: " + tags[i].id);
        }
      }
  
      // Add a new option to the list if it's not inthere already.
      if (!alreadyIncluded) {
        //console.log("not included yet...");
        var newOption = document.createElement("option");
        newOption.className = ("tag_option");
        newOption.innerHTML = tags[i].id;
        
        //console.log("adding child :");
        //console.log(newOption);
        var tagList = document.getElementById("tagList");
        tagList.appendChild(newOption);
        //console.log("updated Taglist: ");
        //console.log(tagList);
      }
    }
  }

// Update the tag array that's inside this script
function updateTagArray() {
    var tagHolder = document.getElementById("tags");
    tagHolder = tagHolder.childNodes;
    tags = [];
  
    for (var i = 0; i < tagHolder.length; i++) {
      if (tagHolder[i].className == "tag")
      {
        tags.push(tagHolder[i]);
      }
    }
}

function GetSelectedTagID() {
    var tagList = document.getElementById("tagList");
    return tagList.options[tagList.selectedIndex].value;
}

tagList.addEventListener("change", updateFields);

function updateFields() {
  var IDOfTag = GetSelectedTagID();
  console.log("!-- SelectedTagID: " + IDOfTag);
  var tags = getTagArray();
  console.log("!-- Tag array:");
  console.log(tags);
  var selectedTag = null;

  for (var i = 0; i < tags.length; i++) {
    if (tags[i].id == IDOfTag) {
        selectedTag = tags[i];
        console.log("!-- found item in tags");
    }
  }

  // Wenn dieses Punkt Daten gespeichert hat, lassen wir es in Textbox veranschaulichen.
  if (selectedTag) {
    if (document.getElementById('tagData').value)
    {
      var tagData = JSON.parse(document.getElementById('tagData').value);
      console.log("selection changed. following data found:");
      console.log(tagData);
      console.log(selectedTag);
      var foundItem = false;
  
      for (var i = 0; i<tagData.length; i++)
      {
        if (tagData[i].id == selectedTag.id)
        {
          foundItem = true;
          field_name.value = tagData[i].title;
          field_description.value = tagData[i].description;
        }
      }
    }

    if (!foundItem)
    {
      field_name.value = "";
      field_description.value = "";
    }
  }
}

button_submit.addEventListener("click", submitChanges);

function submitChanges()
{
  if (document.getElementById('tagData').value)
  {
    /* updating current tags array with the old data downloaded from mysql */
    var tagData = JSON.parse(document.getElementById('tagData').value);

    for (var i = 0; i<tagData.length; i++)
    {
      for (var o=0; o<tags.length;o++)
      {
        if (tagData[i].id == tags[o].id)
        {
          tags[o].title = tagData[i].title;
          tags[o].description = tagData[i].description;
        }
      }
    }
  }

  /* updateing current tags array with the current values of the input fields */
  var tagID=GetSelectedTagID();

  for (var i = 0; i < tags.length; i++) {
    if (tags[i].id == tagID) {
      tags[i].title = field_name.value;
      tags[i].description = field_description.value;
    }
  }

  var tagsJSONString = JSON.stringify(tags);
  document.getElementById('tagData').value = tagsJSONString;
  document.getElementById('tagForm').submit();
}

button_delete.addEventListener("click", submitDelete);

function submitDelete()
{
  /* updating current tags array with the old data downloaded from mysql */
  var tagData = JSON.parse(document.getElementById('tagData').value);

  for (var i = 0; i<tagData.length; i++)
  {
    for (var o=0; o<tags.length;o++)
    {
      if (tagData[i].id == tags[o].id)
      {
        tags[o].title = tagData[i].title;
        tags[o].description = tagData[i].description;
      }
    }
  }

  /* deleting the selected item by making a new array without the item that's to be deleted */
  var tagID=GetSelectedTagID();
  var arrayToExport = [];

  for (var i = 0; i < tags.length; i++) {
    if (tags[i].id != tagID) {
      arrayToExport.push(tags[i]);
    }
  }

  var tagsJSONString = JSON.stringify(arrayToExport);
  document.getElementById('tagData').value = tagsJSONString;
  document.getElementById('tagForm').submit();
}

function LoadDots()
{
  var tagDataSQL = document.getElementById('tagData').value;
  if (tagDataSQL != "") {
    generateTagsFromArray();
    updateTagList();
    tags = JSON.parse(tagDataSQL);
  }
  else
  {
    console.log("found nothing to load... :(");
  }
  
}

LoadDots();

export {updateTagList, GetSelectedTagID};