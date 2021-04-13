$.ajax({
    url: "https://cp465-my-league.herokuapp.com/api/leagues",  
    type: "GET",
    success:function(result){
        var data = JSON.parse(result);     
        for (i in data){
            var row = data[i]
            var leagueRow = document.createElement('tr');
            leagueRow.style.cursor = 'pointer';

            var createClickHandler = function(rowParam) {
                return function() {
                    logout();
                    sessionStorage.setItem('leagueID', rowParam.league_id);
                    window.location.replace("./leaderboard.html");
                };
            };
            leagueRow.innerHTML="<td>"+row.name+"</td>";
            leagueRow.onclick = createClickHandler(row);
            $('#leagueTable tr:last').after(leagueRow);
        }
        },
    error:function(xhr, status, error) {
        var errorMessage = xhr.status + ': ' + xhr.statusText
        alert('Error - ' + errorMessage);
        }
    });