function OpenMenuButtonClick() 
{
    document.getElementById("menuHidden").style.height = "100%";
    document.getElementById("html").style.overflowY = "hidden";
}

function CloseMenuButtonClick() 
{
    document.getElementById("menuHidden").style.height = "0%";
    document.getElementById("html").style.overflowY = "auto";
}

function expandForm(time)
{
    document.getElementById("expand").style.height = "790px";
    setTimeout(function(){showInputs()}, 500);

    setHiddenTimeForm(time);
}

function despandForm()
{
    document.getElementById("expand").style.height = "221px";
    hideInputs();
}

function showInputs()
{
    document.getElementById("hidden").style.display = "block";
    document.getElementById("submit").style.display = "block";
}

function hideInputs()
{
    document.getElementById("hidden").style.display = "none";
    document.getElementById("submit").style.display = "none";
}

function toAppointment()
{
    window.location.replace("../../index.php");
}

function calcDate()
{
    despandForm();

    let selectedDate = document.getElementById("date-input").value;
    let dayNumber = new Date(selectedDate).getDay();
    
    if (selectedDate == "") 
    {
        document.getElementById("times_container").innerHTML = "kies een tijd hierboven :)";
        return;
    } 
    else 
    { 
        if (window.XMLHttpRequest) 
        {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } 
        else 
        {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        xmlhttp.onreadystatechange = function() 
        {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById("times_container").innerHTML = this.responseText;
            }
        };

        xmlhttp.open("GET","includes/views/viewcalcdate.php?q="+selectedDate+"&w="+dayNumber,true);
        xmlhttp.send();
    }
}

function setHiddenTimeForm(time)
{   
    let timeBlocks = document.getElementsByClassName(time.className);
    for (var i = 0; i < timeBlocks.length; i++) 
    {
        timeBlocks[i].style.background = "#00717C";
    }

    time.style.background = "#FFCE06";
    document.getElementById("hiddenTime").value = time.getAttribute('value');
}

function openHidden($id)
{
    //alle objecten ophalen met deze class
    let hiddenInfo = document.getElementsByClassName("hidden_appointment_div");

    //door de objecten array heen
    for (var i = 0; i < hiddenInfo.length; i++) 
    {
        //kijken of ie een classlist 'show' heeft en de id niet hetzelfde is als de geklikte id
        if(hiddenInfo[i].classList.contains("show") && document.getElementById("form"+hiddenInfo[i].id).classList.contains("showInput") && hiddenInfo[i].id != $id)
        {
            hiddenInfo[i].classList.toggle("show");
            document.getElementById("form"+hiddenInfo[i].id).classList.toggle("showInput");
        }
    }

    //geklikte object ophalen
    var infoBlock = document.getElementById($id);
    var infoBlockInput = document.getElementById("form"+$id);

    //class show erop zetten/of eraf
    infoBlock.classList.toggle("show");
    infoBlockInput.classList.toggle("showInput");
}

function addToCalendar(date, time)
{
    let d = ""+date;
    let t = ""+time
    let url = "https://www.google.com/calendar/render?action=TEMPLATE&sf=true&output=xml&text=Afspraak%20Leenheer%20Administraties&location=Aarnoudstraat%2036,%203084%20PB%20Rotterdam,%20Nederland&details=&dates="+d+"T"+t+"Z/"+d+"T"+t+"Z";
    window.open(url,"_blank");
}




