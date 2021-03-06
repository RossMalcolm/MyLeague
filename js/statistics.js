var id = sessionStorage.getItem("leagueID")

$.ajax({
url: "https://cp465-my-league.herokuapp.com/api/stats?league_id="+id,  
type: "GET",
success:function(result){
    var data = JSON.parse(result);     
    for (i in data){
        var row = data[i]
        var leagueRow = document.createElement('tr');

        leagueRow.innerHTML+=("<td>"+row.team_name+"</td>");
        leagueRow.innerHTML+=("<td>"+row.games+"</td>");
        leagueRow.innerHTML+=("<td>"+row.win_percentage.toString().slice(0,5)+"</td>");
        leagueRow.innerHTML+=("<td>"+row.avg_goals_scored_per_game.toString().slice(0,6)+"</td>");
        leagueRow.innerHTML+=("<td>"+row.avg_goals_conceded_per_game.toString().slice(0,6)+"</td>");
        leagueRow.innerHTML+=("<td>"+row.goals_scored+"</td>");
        leagueRow.innerHTML+=("<td>"+row.home_goals_scored+"</td>");
        leagueRow.innerHTML+=("<td>"+row.away_goals_scored+"</td>");
        leagueRow.innerHTML+=("<td>"+row.goals_conceded+"</td>");
        leagueRow.innerHTML+=("<td>"+row.home_goals_conceded+"</td>");
        leagueRow.innerHTML+=("<td>"+row.away_goals_conceded+"</td>");
        $('#leagueTable tr:last').after(leagueRow);
    }
    },
error:function(xhr, status, error) {
    alert("must select a league first");
    window.location.replace("../html/index.html");
    }
});