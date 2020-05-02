Date.prototype.getWeek = function() 
{
    var onjan = new Date(this.getFullYear(),0,1);
    return Math.ceil((((this - onjan) / 86400000) + onjan.getDay()+1)/7);
}

let today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
let currentDay = today.getDay();
let currentWeek = today.getWeek();


let months = ["januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december"];

let monthAndYear = document.getElementById("monthAndYear");

showCalendar(currentMonth, currentYear, currentWeek);

function next() 
{
    currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    currentWeek = (currentWeek + 1) % 52;
    showCalendar(currentMonth, currentYear, currentWeek);
}

function previous() 
{
    currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    currentWeek = (currentWeek - 1) % 52;
    showCalendar(currentMonth, currentYear, currentWeek);
}

function showCalendar(month, year, week, day) 
{
    let firstDay = (new Date(year, month)).getDay();
    let daysInMonth = 32 - new Date(year, month, 32).getDate();

    let tbl = document.getElementById("calendar-body"); // body of the calendar

    // clearing all previous cells
    tbl.innerHTML = "";

    // filing data about month and in the page via DOM.
    monthAndYear.innerHTML = months[month] + " " + year + " " + week;


    // creating all cells
    let date = 1;
    for (let i = 0; i < 6; i++) 
    {
        // creates a table row
        let row = document.createElement("tr");

        //creating individual cells, filing them up with data.
        for (let j = 0; j < 7; j++) 
        {
            if (i === 0 && j < firstDay) 
            {
                let cell = document.createElement("td");
                let cellText = document.createTextNode("");
                cell.appendChild(cellText);
                row.appendChild(cell);
            }
            else if (date > daysInMonth) 
            {
                break;
            }

            else 
            {
                let cell = document.createElement("td");
                let cellText = document.createTextNode(date);
                if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) 
                {
                    cell.classList.add("bg-info");
                } 
                
                // color today's date
                cell.appendChild(cellText);
                row.appendChild(cell);
                date++;
            }
        }

        tbl.appendChild(row); // appending each row into calendar body.
    }
}


/*function next() 
{
    currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    currentWeek = (currentWeek + 1) % 52;
    showCalendar(currentMonth, currentYear, currentWeek);
}

function previous() 
{
    currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    currentWeek = (currentWeek - 1) % 52;
    showCalendar(currentMonth, currentYear, currentWeek);
}

function showCalendar(month, year, week, day) 
{
    let firstDay = (new Date(year, month)).getDay();
    let daysInMonth = 32 - new Date(year, month, 32).getDate();

    let tbl = document.getElementById("calendar-body"); // body of the calendar

    // clearing all previous cells
    tbl.innerHTML = "";

    // filing data about month and in the page via DOM.
    monthAndYear.innerHTML = months[month] + " " + year + " " + week;


    // creating all cells
    let date = 1;
    for (let i = 0; i < 6; i++) 
    {
        // creates a table row
        let row = document.createElement("tr");

        //creating individual cells, filing them up with data.
        for (let j = 0; j < 7; j++) 
        {
            if (i === 0 && j < firstDay) 
            {
                let cell = document.createElement("td");
                let cellText = document.createTextNode("");
                cell.appendChild(cellText);
                row.appendChild(cell);
            }
            else if (date > daysInMonth) 
            {
                break;
            }

            else 
            {
                let cell = document.createElement("td");
                let cellText = document.createTextNode(date);
                if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) 
                {
                    cell.classList.add("bg-info");
                } 
                
                // color today's date
                cell.appendChild(cellText);
                row.appendChild(cell);
                date++;
            }
        }

        tbl.appendChild(row); // appending each row into calendar body.
    }
}*/