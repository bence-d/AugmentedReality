var tags = JSON.parse(document.getElementById('tagData').value);
var tagHolder = document.getElementById("tags");
var showing = false;

for (var i = 0; i < tags.length; i++)
{
    var newDiv = document.createElement("div");
    newDiv.className = "tag";
    newDiv.id = tags[i].id;
    newDiv.style.top = tags[i].Y;
    newDiv.style.left = tags[i].X;
    tagHolder.appendChild(newDiv);

    document.getElementById(tags[i].id).onmouseover = function(){showInfo(this.id);};
    document.getElementById(tags[i].id).onmouseleave = function(){hideInfo();};
}

function showInfo(id)
{
    if (showing == false)
    {
        for (var i = 0; i < tags.length;i++)
        {
            if (id == tags[i].id)
            {
                console.log("match! id:" + id + " tags[i].id:" + tags[i].id);
                document.getElementById('infoBox_title').innerHTML = tags[i].title;
                document.getElementById('infoBox_description').innerHTML = tags[i].description;
                document.getElementById('infoBox').classList.remove('hide');
                document.getElementById('infoBox').classList.add('show');
                showing = true;
            }
        }
    }

    document.getElementById('infoBox').style['left'] = event.clientX + "px";
    document.getElementById('infoBox').style['top'] = event.clientY + "px";
}

function hideInfo(id)
{
    document.getElementById('infoBox').classList.remove('show');
    document.getElementById('infoBox').classList.add('hide');
    showing = false;
}