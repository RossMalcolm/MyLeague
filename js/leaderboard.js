var id = sessionStorage.getItem("leagueID")
        var leagueNames = {}
        $.ajax({
            url: "https://cp465-my-league.herokuapp.com/api/leaderboard?league_id=" + id,  
            type: "GET",
            success:function(result){
                var data = JSON.parse(result);    
                console.log(data) 
                for (i in data){
                    var row = data[i]
                    leagueNames[row.team_id]=row.team_name;
                    
                    var leagueRow = document.createElement('tr');
                    leagueRow.style.cursor = 'pointer';
                    leagueRow.innerHTML="<td>"+row.team_name+"</td><td>"+row.wins+"</td><td>"+row.loss+"</td><td>"+row.OT_loss+"</td><td>"+row.points+"</td>";
                    $('#leagueTable tr:last').after(leagueRow);
                    }
                sessionStorage.setItem("teamNames", JSON.stringify(leagueNames));
                },
                error:function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText
                alert('Error - ' + errorMessage);
                }
            });