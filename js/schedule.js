var id = sessionStorage.getItem("leagueID");
var leagueNames = loadInTeams(id);
console.log(leagueNames);

$.ajax({
url: "https://cp465-my-league.herokuapp.com/api/schedule?league_id="+id+"",  
type: "GET",
success:function(result){
    var data = JSON.parse(result);     
    for (i in data){
        var row = data[i]
        var leagueRow = document.createElement('tr');
        console.log("Goals:");
        console.log(row.home_goals);
        leagueRow.innerHTML+=("<td>"+row.date.slice(0,-3)+"</td>");
        leagueRow.innerHTML+=("<td>"+leagueNames[row.home_team_id]+"</td>");
        leagueRow.innerHTML+=("<td>"+leagueNames[row.away_team_id]+"</td>");
        if(row.home_goals == null && row.away_goals == null){
            leagueRow.innerHTML+="<td> - </td>"
        }else{
            leagueRow.innerHTML+= "<td> "+row.home_goals +" - " + row.away_goals + "</td>"
        }
        
        console.log(leagueRow);
        $('#leagueTable tr:last').after(leagueRow);
    }
    },
error:function(xhr, status, error) {
    alert("must select a league first");
    window.location.replace("../html/index.html");
    }
});

function loadInTeams(id){
    var leagueNames = {}
    $.ajax({
        url: "https://cp465-my-league.herokuapp.com/api/leaderboard?league_id=" + id,  
        type: "GET",
        async: false,
        success:function(result){
            var data = JSON.parse(result);    
            console.log(data);
            for (i in data){
                row = data[i];
                leagueNames[row.team_id]=row.team_name;
                }
            },
            error:function(xhr, status, error) {
                alert("teams could not be loaded");
            }
        });
    return leagueNames;
}