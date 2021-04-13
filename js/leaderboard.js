var id = sessionStorage.getItem("leagueID")
$.ajax({
    url: "https://cp465-my-league.herokuapp.com/api/leaderboard?league_id=" + id,  
    type: "GET",
    success:function(result){
        var data = JSON.parse(result);    
        console.log(data) 
        for (i in data){
            var row = data[i]
            var leagueRow = document.createElement('tr');
            leagueRow.style.cursor = 'pointer';
            leagueRow.innerHTML="<td>"+row.team_name+"</td><td>"+row.wins+"</td><td>"+row.loss+"</td><td>"+row.OT_loss+"</td><td>"+row.points+"</td>";
            $('#leagueTable tr:last').after(leagueRow);
            }
        },
        error:function(xhr, status, error) {
        alert("must select a league first");
        window.location.replace("../html/index.html");
        }
    });