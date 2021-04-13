function populateDropDowns(){
    var homeDropDown = document.getElementById("homeTeam");
    var awayDropDown = document.getElementById("awayTeam");
    var leagueNames = JSON.parse(sessionStorage.getItem("teamNames"));
    for (i in leagueNames){
        console.log(i);
        var leagueRow = document.createElement('option');
        var leagueRow2 = document.createElement('option')
        leagueRow.value = i;
        leagueRow2.value = i;
        leagueRow.innerHTML = leagueNames[i];
        leagueRow2.innerHTML = leagueNames[i];
        homeDropDown.appendChild(leagueRow);
        awayDropDown.appendChild(leagueRow2);
        }
    }

function insertmatch(){
    var id = sessionStorage.getItem("leagueID")
    var leagueNames = JSON.parse(sessionStorage.getItem("teamNames"));
    $.ajax({
        url: "https://cp465-my-league.herokuapp.com/api/createGame",  
        type: "POST",
        data:JSON.stringify({
            "league_id": id,
            "played": false,
            "date": document.getElementById("datetimepicker").value,
            "home_team_id": document.getElementById("homeTeam").value,
            "away_team_id": document.getElementById("awayTeam").value
        }),
        success:function(result){
            var data = JSON.parse(result);     
            console.log(data);
            },
        error:function(xhr, status, error) {
            var errorMessage = xhr.status + ': ' + xhr.statusText
            alert(xhr.responseText);
            alert('Error - ' + errorMessage);
            }
        });
    }

function updateScores(){
    $.ajax({
        url: "https://cp465-my-league.herokuapp.com/api/updateGame",  
        type: "POST",
        data:JSON.stringify({
            "game_id": sessionStorage.getItem("game_id"),
            "home_goals": document.getElementById("home_goals").value,
            "away_goals": document.getElementById("away_goals").value,
            "date": sessionStorage.getItem("game_time")
        }),
        success:function(result){
            var data = JSON.parse(result);     
            console.log(data);
            },
        error:function(xhr, status, error) {
            var errorMessage = xhr.status + ': ' + xhr.statusText
            alert(xhr.responseText);
            alert('Error - ' + errorMessage);
            }
        });
}
    
var leagueNames = JSON.parse(sessionStorage.getItem("teamNames"));
var id = sessionStorage.getItem("leagueID");
$.ajax({
url: "https://cp465-my-league.herokuapp.com/api/schedule?league_id="+id+"",  
type: "GET",
success:function(result){
    var data = JSON.parse(result);     
    console.log(data);
    for (i in data){
        var row = data[i]
        var leagueRow = document.createElement('tr');
        leagueRow.style.cursor = 'pointer';

        var createClickHandler = function(rowParam) {
            return function() {
                sessionStorage.setItem('game_id', rowParam.game_id);
                sessionStorage.setItem('game_time', rowParam.date)
                document.getElementById("match_update").hidden = false;
            };
        };

        leagueRow.innerHTML+=("<td>"+row.date+"</td>");
        leagueRow.innerHTML+=("<td>"+leagueNames[row.home_team_id]+"</td>");
        leagueRow.innerHTML+=("<td>"+leagueNames[row.away_team_id - 1]+"</td>");
        if(row.home_goals == null && row.away_goals == null){
            leagueRow.innerHTML+="<td> - </td>"
        }else{
            leagueRow.innerHTML+= "<td> "+row.home_goals +" - " + row.away_goals + "</td>"
        }
        leagueRow.onclick = createClickHandler(row);
        $('#leagueTable tr:last').after(leagueRow);
    }
    },
error:function(xhr, status, error) {
    var errorMessage = xhr.status + ': ' + xhr.statusText
    alert('Error - ' + errorMessage);
    }
});
    