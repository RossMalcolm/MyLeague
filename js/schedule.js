var leagueNames = JSON.parse(sessionStorage.getItem("teamNames"));
    var id = sessionStorage.getItem("leagueID");
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
            leagueRow.innerHTML+=("<td>"+row.date+"</td>");
            leagueRow.innerHTML+=("<td>"+leagueNames[row.home_team_id]+"</td>");
            leagueRow.innerHTML+=("<td>"+leagueNames[row.away_team_id - 1]+"</td>");
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
        var errorMessage = xhr.status + ': ' + xhr.statusText
        alert('Error - ' + errorMessage);
        }
    });